<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Admin Dashboard</div>
            <div class="card-body">
                Bienvenue sur votre dashboard administrateur
            </div>
        </div>
        <hr />
        <div class="card card-default">
            <div class="card-header">Liste des utilisateurs</div>
            <div class="card-body">
                <userList></userList>
            </div>
        </div>
        <hr />
        <div class="card card-default">
            <div class="card-header">All posts</div>
            <div class="card-body">
                <postList></postList>
            </div>
        </div>
    </div>
</template>
<script>
  import userList from '../../components/user-list.vue'
  import postList from './ListPosts.vue'
  export default {
    mounted() {
      //
    },
    components: {
      userList,
      postList
    }
  }
</script>