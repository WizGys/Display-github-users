<template>
    <div class="contenitore">
        <!-- <span>{{ users[0].avatar_url }}</span> -->
        <button id="home_button" @click="returnHome">Home</button>
        <h1 id="titolo-pagina">User Profiles</h1>

        <!-- <div>{{ parsedUsers[0].details.followers }}</div> -->

        <div>
            <form @submit.prevent="submitForm">
                <input type="number" v-model="param" placeholder="#Users" />
                <button type="submit">Show</button>
            </form>

            <br />

            <form @submit.prevent="submitSingleUser">
                <input
                    type="text"
                    v-model="username"
                    placeholder="Specific Username"
                />
                <button type="submit">Search</button>
            </form>
        </div>

        <div v-if="user" class="single-item" style="margin-top: 5vh">
            <img :src="user.avatar_url" alt="User avatar" />
            <br />
            <h2>{{ user.login }}</h2>
            <p>{{ user.bio }}</p>
            <a :href="user.html_url"
                ><p>{{ user.html_url }}</p></a
            >

            <br />
            <p>Public repos: {{ user.public_repos }}</p>
            <p>Followers: {{ user.followers }}</p>
            <p>Following: {{ user.following }}</p>
            <br />
            <p>
                Created at: {{ new Date(user.created_at).toLocaleDateString() }}
            </p>
            <p>
                Last update:
                {{ new Date(user.updated_at).toLocaleDateString() }}
            </p>
        </div>

        <ul id="all-items">
            <li class="single-item" v-for="user in parsedUsers">
                <img :src="user.avatar_url" alt="{{ user.login }}'s avatar" />
                <h2>{{ user.type }} Id#{{ user.id }}</h2>
                <h2>{{ user.login }}</h2>
                <a :href="user.html_url"
                    ><p>{{ user.html_url }}</p></a
                >

                <div
                    v-if="
                        user.name &&
                        user.followers &&
                        user.following &&
                        user.public_repos &&
                        user.public_gists &&
                        user.created_at
                    "
                >
                    <br />
                    <h2>Followers: {{ user.followers }}</h2>
                    <h2>Following: {{ user.following }}</h2>
                    <br />
                    <h2>Public repos: {{ user.public_repos }}</h2>
                    <h2>Public gists: {{ user.public_gists }}</h2>
                    <br />
                    <h2>
                        Created:
                        {{ new Date(user.created_at).toLocaleDateString() }}
                    </h2>
                    <h2>
                        Last update:
                        {{ new Date(user.updated_at).toLocaleDateString() }}
                    </h2>
                </div>
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
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            param: "",
            username: "",
        };
    },
    methods: {
        submitForm() {
            Inertia.get("/profili/" + this.param);
        },
        submitSingleUser() {
            Inertia.get("/profilo/" + this.username);
        },
        returnHome() {
            Inertia.get("/");
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

.single-item {
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
    transition: transform 0.3s;
}
.single-item:hover {
    box-shadow: 5px 5px 5px 5px #5191f0;

    transform: scale(1.04);
}

#home_button {
    position: fixed;
    top: 5vh;
    left: 1vw;
    padding: 1vh;
    border-radius: 10px;
    font-size: large;
    font-weight: bold;
    background-color: #5191f0;
    color: white;
    border: none;
    cursor: pointer;
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
