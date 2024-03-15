<!-- TaskManager.vue -->
<!-- <template>
    <div class="task-manager">
        <h1>Task Manager</h1>
        <div class="task-input">
            <input v-model="newTask" type="text" placeholder="Enter new task">
            <button @click="addTask">Add Task</button>
        </div>
        <ul class="task-list">
            <li v-for="(task, index) in tasks" :key="task.id">
                <span>{{ task.title }}</span>
                <button @click="deleteTask(task.id)">Delete</button>
            </li>
        </ul>
    </div>
</template> -->

<template>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-semibold mb-4">Task Management</h1>
      <div class="flex flex-col justify-center w-1/2">
        <div class="task-input flex flex-row py-4">
        <Input v-model="newTask" type="text" placeholder="Enter new task"/>
            <button @click="addTask">Add Task</button>
        </div>
        </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Task cards -->
        <div v-for="task in tasks" :key="task.id">
          <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex flex-row justify-between">
                <h2 class="text-xl font-semibold mb-4" v-if="!showEdit">{{ task.title }}</h2>
                <button @click="showEditInput()" class="text-green-500 hover:text-green-700">Edit</button>
            </div>

            <p class="text-gray-600 mb-2">created by : {{ task.owner }}</p>
            <div class="flex justify-between items-center">
              <span class="text-gray-500">{{ task.created }}</span>
              <button @click="deleteTask(task.id)" class="text-red-500 hover:text-red-700">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue'
import Input from '../../components/Input.vue';

const tasks = ref([]);
const newTask = ref('');
const showEdit = ref(false);


const fetchTasks = async () => {
    try {
        const accessToken = localStorage.getItem('access_token');

        if (!accessToken) {

            router.push('/');
        }
        const response = await axios.get("api/tasks", {
            withCredentials: true,
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        });

        tasks.value = response.data;
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
};

const addTask = async () => {
    if (newTask.value.trim() !== '') {
        try {
            const accessToken = localStorage.getItem('access_token');

            if (!accessToken) {

                return;
            }
            const response = await axios.post('api/tasks', {
                title: newTask.value,
                priority: 1
            }, {
                withCredentials: true,
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                }
            });
            tasks.value.push(response.data);
            newTask.value = '';
        } catch (error) {
            console.error('Error adding task:', error);
        }
    }
};


const deleteTask = async (id) => {
    try {
        const accessToken = localStorage.getItem('access_token');

        if (!accessToken) {

            return;
        }
        const response = await axios.delete(`api/tasks/${id}`, {
            withCredentials: true,
            headers: {
                'Authorization': `Bearer ${accessToken}`,
            },
        });
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
};

const showEditInput = () => {
    showEdit.value =!showEdit.value;
}

onMounted(() => {
    const accessToken = localStorage.getItem('access_token');

    if (!accessToken) {

        router.push('/');
    }

    fetchTasks();

    // window.Echo.channel("task-updates").listen("TaskUpdated", (event) => {
    //     console.log("dfgdf")
    //     fetchTasks();
    // });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d1977099133a6e8f7ae2', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('task-updates');
    channel.bind('TaskUpdated', function(data) {
      console.log(JSON.stringify(data));
    });
});
</script>

<style scoped>
.task-manager {
    max-width: 600px;
    margin: 0 auto;
}

.task-input {
    margin-bottom: 20px;
}

.task-input input {
    width: 70%;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
}

.task-input button {
    padding: 8px 16px;
    font-size: 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.task-list {
    list-style-type: none;
    padding: 0;
}

.task-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.task-list li.completed {
    text-decoration: line-through;
}
</style>
