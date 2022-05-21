<template>   
    <div>
       <hr>
       <h2> Comments </h2>
       <div class="comment-block">
        <div class="comment-content" v-for="comment in comments" :key="comment.id" >
            <span class="comment-name">{{ comment.name }}</span>
            <span class="comment-time"><i class="fa fa-clock-o"></i>
               {{moment(comment.created_at).format('llll')}}
           </span>
           <div class="comment-text">
            {{  comment.comment_text }}
        </div>
        <span class="comment-reply"  @click="addReply(comment)"><i class="fa fa-reply" aria-hidden="true"></i> Reply</span>
        <div class="comment-reply-content" v-for="reply in comment.replies" :key="reply.id" >
            <span class="comment-name">{{ reply.name }}</span>
            <span class="comment-time"><i class="fa fa-clock-o"></i>
               {{moment(reply.created_at).format('llll')}}
           </span>
           <div class="comment-text">
            {{  reply.comment_text }}
        </div>
        <span class="comment-reply"  @click="addReply(reply)"><i class="fa fa-reply" aria-hidden="true"></i> Reply</span>
        <div class="comment-re-reply-content" v-for="rereply in reply.replies" :key="rereply.id" >
            <span class="comment-name">{{ rereply.name }}</span>
            <span class="comment-time"><i class="fa fa-clock-o"></i>
               {{moment(rereply.created_at).format('llll')}}
           </span>
           <div class="comment-text">
            {{  rereply.comment_text }}
        </div>
    </div>
</div>

</div>
</div>
<form action="" @submit.prevent="submitComment">
    <div v-if='Object.keys(comment_replied).length > 0'>
        <span>Repling comment from {{ comment_replied.name }} in {{moment(comment_replied.created_at).format('llll')}}</span>
    </div>
    <p class="text-danger" v-if="errors.length">
        <b>Please, check this errors:</b>
        <ul>
          <li v-for="error in errors">{{ error }}</li>
      </ul>
  </p>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" v-model="name">
</div>
<div class="form-group">
    <label for="comment_text">My Comment</label>
    <textarea name="comment_text" id="comment_text" class="form-control" cols="30" rows="5" v-model="comment_text"></textarea>

</div>
<button name="submit" id="submit" type="submit" class="btn btn-primary mt-2 submit">Submit</button>
</form>

</div>
</template>

<script>
    export default {
        //TODO: need be implemented to more posts
        mounted() {
            axios.get('/posts/1/comments')
            .then(response => {
                this.comments = response.data
            })
        },
        data() {
            return {
                comments: [],
                comment_text: '',
                name: '',
                comment_replied: {},
                errors: [],
            }
        },
        methods: {
            submitComment() {
                this.errors = [];
                if (this.name == ''){
                    this.errors.push('The name is required.');
                }
                if (this.comment == ''){
                    this.errors.push('The comment is required.');
                }
                if(this.errors.length == 0){
                    //TODO: need be implemented to more posts
                    axios.post('/posts/1/comments', {
                        comment_text: this.comment_text,
                        name: this.name,
                        comment_replied_id: (Object.keys(this.comment_replied).length === 0 ? null : this.comment_replied.id)
                    })
                    .then(response => {
                        if(response.data.comment_replied_id != null){
                            let comment_replied = _.find(this.comments, {id:response.data.comment_replied_id});
                            if(typeof(comment_replied) == 'undefined'){
                                let comment_replied = _.find(this.comments, _.flow(
                                    _.property('replies'),
                                    _.partialRight(_.some, { id: response.data.comment_replied_id })
                                    ));
                                _.forEach(comment_replied.replies, function(value,key) {                                    
                                  if(value.id == response.data.comment_replied_id){
                                    console.log(value)
                                    comment_replied.replies[key].replies.push(response.data)
                                  }
                              });
                            }else{
                                comment_replied.replies.push(response.data)
                            }
                            
                        }else{
                            this.comments.push(response.data)
                        }                        
                        this.name = '';
                        this.comment_text = '';
                        this.comment_replied = [];
                    })
                }
                
            },
            addReply(comment) {
                this.comment_replied = comment;
            }
        }
    }
</script>
<style scoped>
.comment-block {
    margin-bottom: 15px;
    border: 1px solid #edeff2;
    border-radius: 2px;
    padding: 20px 0px;
    border:1px solid #ffffff;
}

.comment-content span {
    display: inline-block;
    width: 49%;
    margin-bottom: 5px;
}

.comment-name {
    font-size: 1em;
}

.comment-reply-content {
    margin-left: 2em;
}

.comment-re-reply-content {
    margin-left: 4em;
}

.comment-time {
    text-align: right;
    font-size: 0.6em;
    color: #b4b7c1;
}

.comment-reply{
    text-align: left;
    font-size: 0.6em;
    color: #b4b7c1;
    display: inline-block;
    margin-bottom: 5px;
}

.comment-text {
    font-size: 0.7em;;
    color: #7a8192;
    display: block;
    background: #f6f6f7;
    border: 1px solid #edeff2;
    padding: 15px 20px 20px 20px;
}

</style>