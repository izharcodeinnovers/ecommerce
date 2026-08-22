<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineProps<{
    passwordRules: string;
}>();

defineOptions({
    layout: {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
    },
});
</script>

<template>
    <Head title="Register" />

    <div class="fixed inset-0 z-50 overflow-y-auto bg-white dark:bg-gray-900">
        <div class="flex min-h-screen justify-center">
            <div
                class="hidden bg-cover lg:block lg:w-2/5"
                style="
                    background-image: url('https://images.unsplash.com/photo-1494621930069-4fd4b2e24a11?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=715&q=80');
                "
            ></div>

            <div
                class="mx-auto flex w-full max-w-3xl items-center p-8 lg:w-3/5 lg:px-12"
            >
                <div class="w-full">
                    <h1
                        class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white"
                    >
                        Get your free account now.
                    </h1>

                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                        Let's get you all set up so you can verify your personal
                        account and begin setting up your profile.
                    </p>

                    <div class="mt-6">
                        <h1 class="text-gray-500 dark:text-gray-300">
                            Select type of account
                        </h1>

                        <div class="mt-3 md:-mx-2 md:flex md:items-center">
                            <button
                                type="button"
                                class="flex w-full justify-center rounded-lg bg-blue-500 px-6 py-3 text-white focus:outline-none md:mx-2 md:w-auto"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>

                                <span class="mx-2"> client </span>
                            </button>

                            <button
                                type="button"
                                class="mt-4 flex w-full justify-center rounded-lg border border-blue-500 px-6 py-3 text-blue-500 focus:outline-none md:mx-2 md:mt-0 md:w-auto dark:border-blue-400 dark:text-blue-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>

                                <span class="mx-2"> worker </span>
                            </button>
                        </div>
                    </div>

                    <Form
                        v-bind="store.form()"
                        :reset-on-success="[
                            'password',
                            'password_confirmation',
                        ]"
                        v-slot="{ errors, processing }"
                        class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2"
                    >
                        <div>
                            <Label
                                for="name"
                                class="mb-2 block text-sm text-gray-600 dark:text-gray-200"
                                >Name</Label
                            >
                            <Input
                                id="name"
                                type="text"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="name"
                                name="name"
                                placeholder="Full name"
                                class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-3 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                            />
                            <InputError :message="errors.name" />
                        </div>

                        <div>
                            <Label
                                for="email"
                                class="mb-2 block text-sm text-gray-600 dark:text-gray-200"
                                >Email address</Label
                            >
                            <Input
                                id="email"
                                type="email"
                                required
                                :tabindex="2"
                                autocomplete="email"
                                name="email"
                                placeholder="email@example.com"
                                class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-3 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                            />
                            <InputError :message="errors.email" />
                        </div>

                        <div>
                            <Label
                                for="password"
                                class="mb-2 block text-sm text-gray-600 dark:text-gray-200"
                                >Password</Label
                            >
                            <PasswordInput
                                id="password"
                                required
                                :tabindex="3"
                                autocomplete="new-password"
                                name="password"
                                placeholder="Enter your password"
                                :passwordrules="passwordRules"
                                class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-3 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <div>
                            <Label
                                for="password_confirmation"
                                class="mb-2 block text-sm text-gray-600 dark:text-gray-200"
                                >Confirm password</Label
                            >
                            <PasswordInput
                                id="password_confirmation"
                                required
                                :tabindex="4"
                                autocomplete="new-password"
                                name="password_confirmation"
                                placeholder="Enter your password"
                                :passwordrules="passwordRules"
                                class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-3 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                            />
                            <InputError
                                :message="errors.password_confirmation"
                            />
                        </div>

                        <Button
                            type="submit"
                            class="focus:ring-opacity-50 flex w-full transform items-center justify-between rounded-lg bg-blue-500 px-6 py-3 text-sm tracking-wide text-white capitalize transition-colors duration-300 hover:bg-blue-400 focus:ring focus:ring-blue-300 focus:outline-none md:col-span-2"
                            tabindex="5"
                            :disabled="processing"
                            data-test="register-user-button"
                        >
                            <span>Sign Up </span>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 rtl:-scale-x-100"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </Button>
                    </Form>

                    <div class="mt-6 text-center text-sm text-gray-400">
                        Already have an account?
                        <TextLink
                            :href="login()"
                            class="text-blue-500 hover:underline focus:underline focus:outline-none"
                            :tabindex="6"
                            >Log in</TextLink
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
