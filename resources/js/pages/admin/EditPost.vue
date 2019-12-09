<template>
  <div class="card mt-4">
    <div class="card-header">Edit Post</div>
    <div class="card-body">
      <div
        v-if="status_msg"
        :class="{ 'alert-success': status, 'alert-danger': !status }"
        class="alert"
        role="alert"
      >{{ status_msg }}</div>
      <form>
        <div class="form-group">
          <label for="exampleFormControlInput1">Title</label>

          <input
            v-model="post.title"
            type="text"
            class="form-control"
            id="title"
            placeholder="Post Title"
            required
          />
        </div>
        <div class="form-group">
          <label for="example Form Control Textarea 1">Post Content</label>

          <textarea v-model="post.body" class="form-control" id="post-content" rows="3" required></textarea>
        </div>
        <div class>
          <div class="col-md-6" v-for="(img, i) in this.post.post_images" :key=i>
            <img :src="img.post_image_path" class="img-thumbnail" alt />
          </div>

          <el-upload
            action="/"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-change="updateImageList"
            :auto-upload="false"
          >
            <i class="el-icon-plus"></i>
          </el-upload>

          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt />
          </el-dialog>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <button
        type="button"
        @click="updatePost"
        class="btn btn-success"
      >{{ isUpdatingPost ? "Saving ..." : "Update Post" }}</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";

export default {
  name: "edit-post",
  data() {
    return {
      post: {},
      dialogImageUrl: "",
      dialogVisible: false,
      imageList: {},
      status_msg: "",
      status: "",
      isUpdatingPost: false,
      title: "",
      body: ""
    };
  },
  created() {
    let uri = `/post/${this.$route.params.id}`;
    this.axios.get(uri).then((response) => {
        this.post = response.data.data;
        this.imageList = this.post.post_images;
    });
  },
  methods: {
    updateImageList(file) {
      this.imageList.push(file.raw);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    showNotification(message) {
      this.status_msg = message;
      setTimeout(() => {
        this.status_msg = "";
      }, 3000);
    },
    validateForm() {
      if (!this.post.title) {
        this.status = false;
        this.showNotification("Post title cannot be empty");
        return false;
      }
      if (!this.post.body) {
        this.status = false;
        this.showNotification("Post body cannot be empty");
        return false;
      }
      if (this.imageList.length < 1) {
        this.status = false;
        this.showNotification("You need to select an image");
        return false;
      }
      return true;
    },

    updatePost(e) {
      e.preventDefault();
      if (!this.validateForm()) {
        return false;
      }

      this.isUpdatingPost = true;
      let formData = new FormData();

      formData.append("title", this.post.title);
      formData.append("body", this.post.body);

      $.each(this.imageList, function(key, image) {
        formData.append(`images[${key}]`, image);
      });

      axios
        .post("/post/"+this.post._id, formData, {
          headers: { "Content-Type": "multipart/form-data" } 
        })
        .then(res => {
          this.title = this.body = "";
          this.status = true;
          this.showNotification("Post Successfully updated");
          this.isUpdatingPost = false;
        });
    }
  }
};
</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}

.avatar-upload-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
