import ApiService from '../../api'
import { reject } from 'q'
import router from './../../router'

export default {
    namespaced: true,
    state: {
        posts: {},
        allPosts: {},
        errors: '',
        message: '',
        post: {
            title: '',
            description_short: '',
            seo_title: '',
            image_thumb: '',
            categories: '',
            description: '',
            status: ''
        },
        companies: []
    },
    mutations: {
        setAllPosts (state, data) {
            state.allPosts = data
        },
        setPosts (state, data) {
            state.posts = data
        },
        setErrors (state, data) {
            state.errors = data
        },
        setMessage (state, data) {
            state.message = data
        },
        setPost (state, data) {
            state.post = data
        },
        deletePost (state, data) {
            state.posts = data
        }
    },
    actions: {
        clearPost (context) {
            const data = {
                title: '',
                description_short: '',
                seo_title: '',
                image_thumb: '',
                categories: '',
                description: '',
                statue: ''
            }
            context.commit('setPost', data)
        },

        //get list post for paginate
        getPosts (context) {
            return new Promise(resolve => {
                ApiService.get('/api/posts')
                    .then(({
                        data
                    }) => {
                        context.commit('setPosts', data)
                        resolve(data)
                    })
                    .catch( err => {
                        context.commit('setErrors', err)
                    })
            })
        },

        getAllPosts (context) {
            return new Promise(resolve => {
                ApiService.get('/api/posts/all')
                    .then(({
                        data
                    }) => {
                        context.commit('setAllPosts', data)
                        resolve(data)
                    })
                    .catch( err => {
                        context.commit('setErrors', err)
                    })
            })
        },

        //add post
        addPost (context, data) {
            data.selected = []            
            data.selected.push(data.categories.id)
            return new Promise(resolve => {
                ApiService.post('/api/posts/add', data)
                    .then(({data}) => {
                        if (data.status === 200) {
                            context.commit('setPost', data.message)
                            router.push({ name: 'listPost' })
                            window.toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            resolve(data)
                        } else {
                            window.toast.fire({
                                icon: 'error',
                                title: 'Tạo bài viết thất bại!'
                            })
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        reject(err)
                    })
            })
        },

        //delete post
        deletePost ({context, dispatch}, id) {
            return new Promise(resolve => {
                ApiService.delete('/api/posts/delete/' +  id)
                    .then(({data}) => {
                        if (data.status === 200) {
                            dispatch('getPosts')
                            window.swal.fire(
                                '',
                                data.message,
                                'success'
                            )
                            resolve(data)
                        } else {
                            window.swal.fire(
                                '',
                                data.error,
                                'error'
                            )
                            context.commit('setErrors', data.error)
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        reject(err)
                    })
            })
        },

        //get info post
        editPost (context, idPost) {
            return new Promise(resolve => {
                ApiService.get('/api/posts/edit/' + idPost)
                    .then(({ data }) => {
                        context.commit('setPost', data)
                        resolve(data)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            })
        },

        //update post
        updatePost (context, data) {
            data.selected = []            
            data.selected.push(data.categories.id)
            return new Promise(resolve => {
                const idPost = data.id
                ApiService.put('/api/posts/update/' + idPost, data)
                    .then(({ data }) => {
                        if(data.status === 200) {
                            context.commit('setPosts', data)
                            router.push({
                                name: 'listPost'
                            })
                            window.toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            resolve(data)
                        } else {
                            window.toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            })
        }

    }
}
