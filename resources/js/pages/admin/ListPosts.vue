<template>
  <div class="row">
    <div
      v-if="status_msg"
      :class="{ 'alert-success': status, 'alert-danger': !status }"
      class="alert col-md-12"
      role="alert"
    >{{ status_msg }}</div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-3">
          <strong>1st Image</strong>
        </div>
        <div class="col-md-3">
          <strong>Title</strong>
        </div>
        <div class="col-md-4">
          <strong>Content</strong>
        </div>
        <div class="col-md-2">
          <strong>Activation</strong>
        </div>
      </div>
    </div>
    <div class="col-md-12" v-for="(post, i) in posts" :key="i">
      <div class="row">
        <div class="col-md-3">
          <img
            v-if="post.post_images.length"
            class="card-img-top"
            :src="post.post_images[0].post_image_path"
          />
        </div>
        <div class="col-md-3">
          <strong>{{ post.title }}</strong>
        </div>
        <div class="col-md-4">
          <strong>{{ truncateText(post.body) }}</strong>
        </div>
        <div class="col-md-2">
          <button class="btn btn-success m-2" @click="viewPost(i)">View</button>
          <br />
          <a class="btn btn-info m-2" :href="'/post/' + post._id">Edit</a>
          <br />
          <button class="btn btn-warning m-2" @click="deletePost(post._id)">Delete</button>
        </div>
      </div>
    </div>
    <el-dialog v-if="currentPost" :visible.sync="postDialogVisible" width="40%">
      <span>
        <h3>{{ currentPost.title }}</h3>
        <div class="row">
          <div class="col-md-6" v-for="(img, i) in currentPost.post_images" :key="i">
            <img :src="img.post_image_path" class="img-thumbnail" alt />
          </div>
        </div>
        <hr />
        <p>{{ currentPost.body }}</p>
      </span>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="postDialogVisible = false">Okay</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
import { mapState } from "vuex";
import CreatePost from './CreatePost.vue'


export default {
  name: "list-posts",
  data() {
    return {
      postDialogVisible: false,
      isDeletingPost: false,
      status_msg: "",
      status: "",
      currentPost: ""
    };
  },
  beforeMount() {
    this.$store.dispatch("getAllPosts");
  },
  computed: {
    ...mapState(["posts"]),
  },
  methods: {
    ...mapActions(["getAllPosts"]),
    truncateText(text) {
      if (text.length > 24) {
        return `${text.substr(0, 24)}...`;
      }
      return text;
    },
    showNotification(message) {
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = "";
      }, 3000);
    },
    viewPost(postIndex) {
      const post = this.posts[postIndex];
      this.currentPost = post;
      this.postDialogVisible = true;
    },
    deletePost(postId) {
      if (confirm("Confirm delete?")) {
        this.isDeletingPost = true;

        axios
          .delete("/post/" + postId, {
            headers: { "Content-Type": "multipart/form-data" }
          })
          .then(res => {
            this.status = true;
            this.isDeletingPost = false;
            this.showNotification("Post Successfully Deleted");
            this.getAllPosts();
          });
      }
    }
  }
};
</script>