# Enterprise Multi-Vendor E-Commerce Database Schema

## Assumptions
- MySQL 8+ or PostgreSQL 15+.
- UUIDs may be used externally; bigint primary keys shown for simplicity.
- All business tables include `created_at` and `updated_at` unless noted.
- Soft deletes use `deleted_at` where recovery is valuable.
- Monetary fields use DECIMAL(18,4).
- Multi-vendor marketplace is a core requirement.

---

# Naming Standards

- Primary Key: `id`
- Foreign Key: `<entity>_id`
- Timestamps: `created_at`, `updated_at`
- Soft Delete: `deleted_at`
- Status columns use ENUM or lookup values.
- Indexed columns marked with `[IDX]`.

---

# Authentication & Authorization

## users
Purpose: System users (customers, vendors, admins)

| Column | Type | Null | Notes |
|----------|----------|----------|----------|
| id | bigint PK | No | Primary key |
| email | varchar(255) | No | Unique |
| phone | varchar(30) | Yes | Unique |
| password | varchar(255) | No | |
| status | enum(active,inactive,blocked) | No | indexed |
| last_login_at | timestamp | Yes | |
| created_at | timestamp | No | |
| updated_at | timestamp | No | |
| deleted_at | timestamp | Yes | soft delete |

Indexes:
- unique(email)
- unique(phone)
- index(status)

## roles
- id PK
- name unique
- description

## permissions
- id PK
- name unique
- description

## role_user
- user_id FK users.id
- role_id FK roles.id
- PK(user_id, role_id)

## permission_role
- role_id FK
- permission_id FK
- PK(role_id, permission_id)

---

# Customer Module

## customer_profiles
- id PK
- user_id FK unique
- first_name
- last_name
- gender
- dob

## customer_addresses
- id PK
- user_id FK
- type (billing/shipping)
- country_id FK
- state_id FK
- city
- address_line_1
- address_line_2
- postcode
- is_default

Indexes:
- user_id
- postcode

---

# Vendor Module

## vendors
- id PK
- user_id FK unique
- store_name
- slug unique
- status (pending,approved,rejected,suspended)
- commission_rate
- verified_at

Indexes:
- slug
- status

## vendor_profiles
- vendor_id FK unique
- description
- logo
- banner

## vendor_documents
- id PK
- vendor_id FK
- document_type
- file_path
- status

## vendor_bank_accounts
- id PK
- vendor_id FK
- bank_name
- account_name
- account_number
- iban

## vendor_staff
- id PK
- vendor_id FK
- user_id FK

---

# Catalog

## brands
- id PK
- name unique
- slug unique
- logo

## categories
- id PK
- parent_id FK categories.id
- name
- slug unique
- status

Indexes:
- parent_id
- slug

## products
- id PK
- vendor_id FK
- brand_id FK
- type
- sku unique
- name
- slug unique
- short_description
- description
- status
- visibility
- tax_class_id FK
- created_at
- updated_at
- deleted_at

Indexes:
- vendor_id
- brand_id
- sku
- slug
- status

## product_categories
- product_id FK
- category_id FK
- PK(product_id, category_id)

## attributes
- id PK
- code unique
- name
- type

## attribute_options
- id PK
- attribute_id FK
- value

## product_attribute_values
- product_id FK
- attribute_id FK
- value_text

## product_variants
- id PK
- product_id FK
- sku unique
- barcode
- price
- special_price
- status

## product_images
- id PK
- product_id FK
- path
- sort_order

## product_videos
- id PK
- product_id FK
- url

## tags
- id PK
- name unique

## product_tags
- product_id FK
- tag_id FK

---

# Inventory

## warehouses
- id PK
- name
- code unique

## inventory_items
- id PK
- product_variant_id FK
- warehouse_id FK
- qty_available
- qty_reserved
- reorder_level

Unique:
- (product_variant_id, warehouse_id)

## inventory_transactions
- id PK
- inventory_item_id FK
- type(in,out,adjustment,reserve,release)
- quantity
- reference_type
- reference_id

---

# Cart & Wishlist

## carts
- id PK
- user_id FK nullable
- session_id indexed
- currency_code

## cart_items
- id PK
- cart_id FK
- product_variant_id FK
- quantity
- unit_price

## wishlists
- id PK
- user_id FK

## wishlist_items
- wishlist_id FK
- product_id FK

---

# Orders

## orders
- id PK
- order_number unique
- customer_id FK users.id
- billing_address_id FK
- shipping_address_id FK
- currency_code
- subtotal
- discount_total
- tax_total
- shipping_total
- grand_total
- status
- payment_status
- created_at

Indexes:
- order_number
- customer_id
- status
- created_at

## order_items
- id PK
- order_id FK
- vendor_id FK
- product_id FK
- product_variant_id FK
- sku
- qty
- price
- tax_amount
- row_total

## order_status_history
- id PK
- order_id FK
- status
- comment

---

# Invoices

## invoices
- id PK
- order_id FK
- invoice_number unique
- total

## invoice_items
- id PK
- invoice_id FK
- order_item_id FK

---

# Shipping

## shipping_carriers
- id PK
- code unique
- name

## shipments
- id PK
- order_id FK
- vendor_id FK
- carrier_id FK
- tracking_number indexed
- status

## shipment_items
- shipment_id FK
- order_item_id FK

---

# Returns & Refunds

## return_requests
- id PK
- order_item_id FK
- customer_id FK
- reason
- status

## refunds
- id PK
- order_id FK
- refund_number unique
- amount
- status

---

# Payments

## payment_methods
- id PK
- code unique
- name

## payments
- id PK
- order_id FK
- payment_method_id FK
- transaction_id indexed
- amount
- status

## payment_transactions
- id PK
- payment_id FK
- gateway_reference
- type
- amount

---

# Promotions

## coupons
- id PK
- code unique
- type
- value
- starts_at
- ends_at

## coupon_redemptions
- coupon_id FK
- order_id FK
- customer_id FK

## promotion_rules
- id PK
- name
- rule_type
- conditions_json

---

# Reviews

## product_reviews
- id PK
- product_id FK
- customer_id FK
- rating CHECK rating BETWEEN 1 AND 5
- review
- status

## vendor_reviews
- id PK
- vendor_id FK
- customer_id FK
- rating CHECK rating BETWEEN 1 AND 5
- review

---

# Vendor Commission & Settlement

## vendor_commissions
- id PK
- vendor_id FK
- order_item_id FK
- commission_rate
- commission_amount

## vendor_settlements
- id PK
- vendor_id FK
- period_start
- period_end
- payable_amount
- status

## vendor_payouts
- id PK
- settlement_id FK
- payout_reference
- amount
- status

---

# CMS

## pages
- id PK
- slug unique
- title
- content
- status

## blog_categories
- id PK
- name
- slug unique

## blog_posts
- id PK
- category_id FK
- slug unique
- title
- content
- status

---

# Notifications

## notifications
- id PK
- user_id FK
- type
- title
- body
- read_at

## notification_logs
- id PK
- notification_id FK
- channel(email,sms,push)
- status

---

# Support

## tickets
- id PK
- customer_id FK nullable
- vendor_id FK nullable
- subject
- status

## ticket_messages
- id PK
- ticket_id FK
- user_id FK
- message

---

# Audit

## audit_logs
- id PK
- user_id FK
- entity_type
- entity_id
- action
- old_values_json
- new_values_json

Indexes:
- (entity_type, entity_id)
- user_id

---

# Geography

## countries
- id PK
- iso_code unique
- name

## states
- id PK
- country_id FK
- name

---

# Core Relationships

- User 1:1 CustomerProfile
- User 1:1 Vendor
- Vendor 1:M Products
- Product M:M Categories
- Product 1:M Variants
- Variant 1:M InventoryItems
- Customer 1:M Orders
- Order 1:M OrderItems
- Order 1:M Payments
- Order 1:M Shipments
- Vendor 1:M Settlements
- Vendor 1:M Reviews
- Product 1:M Reviews
