<template>
    <div class="contenitore">
        <!-- <span>{{ users[0].avatar_url }}</span> -->
        <h1 id="titolo-pagina">User Profiles</h1>

        <!-- <div>{{ parsedUsers[0].details.followers }}</div> -->

        <div>
            <form @submit.prevent="submitForm">
            <input type="number" v-model="param" placeholder="#users" />
            <button type="submit">Show</button>
        </form>
        
        <form @submit.prevent="submitSingleUser">
            <input type="text" v-model="username" placeholder="Specific Username" />
            <button type="submit">Search</button>
        </form>
        </div> 

        <ul id="all-items">
            <li id="single-item" v-for="user in parsedUsers">
                <img :src="user.avatar_url" alt="{{ user.login }}'s avatar" />
                <h2>{{ user.type }} Id#{{ user.id }} </h2>
                <h2>{{ user.login }}</h2>
                <a :href="user.html_url"
                    ><p>{{ user.html_url }}</p></a
                >

                <div v-if="user.name">
                    <br>
                <h2>Followers: {{ user.details.followers }}</h2>
                <h2>Following: {{ user.details.following }}</h2>
                <br>
                <h2>Public repos: {{ user.details.public_repos }}</h2>
                <h2>Public gists: {{ user.details.public_gists }}</h2>
                <br>
                <h2>Created: {{ new Date(user.details.created_at).toLocaleDateString() }}</h2>
                <h2>Last update: {{ new Date(user.details.updated_at).toLocaleDateString() }}</h2>
                </div>
                



                <!-- <br>
                <h2>Followers:{{user.details.followers}} Following: {{ user.detail.following }}</h2> -->
                <!-- <br>
                <h2>Created:{{user.details.created_at}} Last update: {{ user.detail.updated_at }}</h2> -->

                
            </li>
        </ul>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        users: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            param: "",
        };
    },
    methods: {
        submitForm() {
            Inertia.get("/profili/" + this.param);
        },
        submitSingleUser() {
            Inertia.get("/profilo/" + this.username);
        },
    },
    computed: {
        parsedUsers() {
            return this.users;
        },
    },
    created() {
        console.log(this.users);
    },
};
</script>

<style>
.contenitore {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

#titolo-pagina {
    margin-top: 5vh;
    margin-bottom: 5vh;
    font-size: xx-large;
    font-weight: bold;
}

#all-items {
    padding: 3vw;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

#single-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-bottom: 5vh;
    padding: 5vh;
    margin-left: 3vw;
    margin-right: 3vw;
    border: 1px solid black;
    border-radius: 10px;
    box-shadow: 5px 5px 5px 5px #888888;
}

img {
    width: 100px;
    border-radius: 10px;
    justify-self: center;
    margin-bottom: 3vh;
}

a:hover {
    color: blue;
    text-decoration: underline;
}
</style>
