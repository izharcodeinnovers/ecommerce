<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasskeyVerify from '@/components/PasskeyVerify.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Log in" />

    <div class="fixed inset-0 z-50 overflow-y-auto bg-white dark:bg-gray-900">
        <div class="flex min-h-screen justify-center">
            <div
                class="hidden bg-cover lg:block lg:w-2/3"
                style="
                    background-image: url(https://images.unsplash.com/photo-1616763355603-9755a640a287?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80);
                "
            >
                <div
                    class="bg-opacity-40 flex h-full items-center bg-gray-900 px-20"
                >
                    <div>
                        <h2 class="text-2xl font-bold text-white sm:text-3xl">
                            Meraki UI
                        </h2>

                        <p class="mt-3 max-w-xl text-gray-300">
                            Lorem ipsum dolor sit, amet consectetur adipisicing
                            elit. In autem ipsa, nulla laboriosam dolores,
                            repellendus perferendis libero suscipit nam
                            temporibus molestiae
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="mx-auto flex w-full max-w-md items-center px-6 lg:w-2/6"
            >
                <div class="flex-1">
                    <div class="text-center">
                        <div class="mx-auto flex justify-center">
                            <img
                                class="h-7 w-auto sm:h-8"
                                src="https://merakiui.com/images/logo.svg"
                                alt=""
                            />
                        </div>

                        <p class="mt-3 text-gray-500 dark:text-gray-300">
                            Sign in to access your account
                        </p>
                    </div>

                    <div class="mt-8">
                        <div
                            v-if="status"
                            class="mb-4 text-center text-sm font-medium text-green-600"
                        >
                            {{ status }}
                        </div>

                        <PasskeyVerify />

                        <Form
                            v-bind="store.form()"
                            :reset-on-success="['password']"
                            v-slot="{ errors, processing }"
                            class="flex flex-col gap-6"
                        >
                            <div class="grid gap-6">
                                <div class="grid gap-2">
                                    <Label
                                        for="email"
                                        class="mb-2 block text-sm text-gray-600 dark:text-gray-200"
                                        >Email address</Label
                                    >
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        required
                                        autofocus
                                        :tabindex="1"
                                        autocomplete="email"
                                        placeholder="email@example.com"
                                        class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                                    />
                                    <InputError :message="errors.email" />
                                </div>

                                <div class="grid gap-2">
                                    <div class="mb-2 flex justify-between">
                                        <Label
                                            for="password"
                                            class="text-sm text-gray-600 dark:text-gray-200"
                                            >Password</Label
                                        >
                                        <TextLink
                                            v-if="canResetPassword"
                                            :href="request()"
                                            class="text-sm text-gray-400 hover:text-blue-500 hover:underline focus:text-blue-500"
                                            :tabindex="5"
                                        >
                                            Forgot password?
                                        </TextLink>
                                    </div>
                                    <PasswordInput
                                        id="password"
                                        name="password"
                                        required
                                        :tabindex="2"
                                        autocomplete="current-password"
                                        placeholder="Your Password"
                                        class="focus:ring-opacity-40 mt-2 block w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-blue-400"
                                    />
                                    <InputError :message="errors.password" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <Label
                                        for="remember"
                                        class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-200"
                                    >
                                        <Checkbox
                                            id="remember"
                                            name="remember"
                                            :tabindex="3"
                                        />
                                        <span>Remember me</span>
                                    </Label>
                                </div>

                                <Button
                                    type="submit"
                                    class="focus:ring-opacity-50 mt-4 w-full transform rounded-lg bg-blue-500 px-4 py-2 tracking-wide text-white transition-colors duration-300 hover:bg-blue-400 focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:outline-none"
                                    :tabindex="4"
                                    :disabled="processing"
                                    data-test="login-button"
                                >
                                    <Spinner v-if="processing" />
                                    Log in
                                </Button>
                            </div>

                            <div class="mt-6">
                                <p class="text-center text-sm text-gray-400">
                                    Don't have an account yet?
                                    <TextLink
                                        :href="register()"
                                        class="text-blue-500 hover:underline focus:underline focus:outline-none"
                                        :tabindex="5"
                                        >Sign up</TextLink
                                    >.
                                </p>
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
