<template>
        <div class="flex bg-white rounded-xl justify-center mt-10">
            <div class="flex-1 flex flex-col justify-center items-center py-8 px-4 sm:px-6 lg:flex-none lg:px-10 xl:px-14 shadow-md">
                <div class="mx-auto w-full max-w-sm lg:w-96">

                        <div class="mt-6">
                            <form @submit.prevent="submit" class="space-y-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Email address
                                    </label>
                                    <div class="mt-1">
                                        <Input v-model="email" id="email" name="email" type="email" autocomplete="email" required=""/>


                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        Password
                                    </label>
                                    <div class="mt-1">
                                        <Input v-model="password" id="password" name="password" type="password" autocomplete="current-password" required=""/>
                                    </div>
                                </div>

                                <div>
                                    <Button type="submit" class="w-full">
                                        {{ loading ? 'Processing' :'Sign in' }}
                                    </Button>
                                </div>
                                <div class="text-sm">
                                    <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                                        You don't have an account ?
                                    </a>
                                </div>
                            </form>
                        </div>

                </div>
            </div>

        </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import  Input  from '@/components/Input.vue';

const email = ref('');
const password = ref('');
const loading = ref(false);
const router = useRouter();

const submit = async () => {
    try {
        loading.value=true
        const response = await axios.post('api/login', {
            email: email.value,
            password: password.value,
        });

        const accessToken = response.data.token;
        localStorage.setItem('access_token', accessToken);
        router.push('/dashboard');
    } catch (error) {
        console.error('Login failed:', error);
    }
};
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
}

button {
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>
