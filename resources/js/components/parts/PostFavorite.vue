<template>
    <div class="">
        <div class="star tooltip flex items-center" @click="favorite(post.id)"
             v-if="!post.favorite && !loading" aria-label="Seçilmişlərə əlavə et"
             data-balloon-pos="down">
            <span class="iconify text-gray-500 dark:text-gray-300" data-icon="fa-solid:save" data-inline="false"></span>
            {{ post.favorites }}
        </div>
        <div class="star tooltip flex items-center" @click="favorite(post.id)"
             v-if="post.favorite && !loading" aria-label="Seçilmişlərdən cixartmag"
             data-balloon-pos="down">
            <i v-if="post.favorite" class="iconify text-gray-500 dark:text-gray-300" data-icon="fa-solid:save"/>
            {{ post.favorites }}
        </div>
        <div class="star tooltip flex items-center"
             v-if="loading" aria-label="Seçilmişlərdən cixartmag"
             data-balloon-pos="down">
            <div class="animate-spin">
                <span class="iconify text-gray-500 dark:text-gray-300" data-icon="mdi-loading"></span>
            </div>
            {{ post.favorites }}
        </div>
    </div>
</template>

<script>
import Noty from 'noty'
import axios from 'axios'

export default {
    name: "favorite",
    props: ['post', 'auth_check'],
    data: function () {
        return {
            loading: false
        }
    },
    methods: {
        favorite: function (id) {
            this.loading = true;
            if (this.auth_check)
                axios.post('/article/favorite/' + id, {
                    id: id,
                })
                    .then(response => {
                        if (response.data.success) {
                            this.post.favorites++;
                            this.post.favorite = true;
                            new Noty({
                                type: 'success',
                                text: '<div class="notification-image"><i class="iconify" data-icon="mdi-bookmark-plus"></i></div> Paylaşma seçilmişlərə əlave olundu',
                            }).show();
                        } else if (response.data.delete) {
                            this.post.favorites--;
                            this.post.favorite = false;
                            new Noty({
                                type: 'error',
                                text: '<div class="notification-image"><i class="iconify" data-icon="mdi-bookmark-remove"></i></div> Paylaşma seçilmişlərdən silindi',
                            }).show();
                        }
                        this.loading = false;
                    })
                    .catch(error => {
                        if (error.response.status === 401)
                            new Noty({
                                type: 'success',
                                text: '<div class="notification-image"><i class="iconify" data-icon="mdi-account-box"></i></div> <div class="text">Bu funksiyanı istifadə etmək üçün <a href="/register" class="notification-link">qeydiyyatdan keçin</a></div>',
                            }).show();
                        else
                            new Noty({
                                type: 'error',
                                text: '<div class="notification-image"><i class="iconify" data-icon="mdi-minus-box-outline"/></div> Qanunsuz əməliyyat',
                            }).show();
                        this.loading = false;
                    });
            else {
                new Noty({
                    type: 'success',
                    text: '<div class="notification-image"><i class="iconify" data-icon="mdi-account-box"></i></div> <div class="text">Bu funksiyanı istifadə etmək üçün <a href="/register" class="notification-link">qeydiyyatdan keçin</a></div>',
                }).show();
                this.loading = false;
            }
        },
    }
}
</script>
