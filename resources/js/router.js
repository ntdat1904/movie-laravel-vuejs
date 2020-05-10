import VueRouter from 'vue-router'
// Pages
import Index from './pages/admin/Index'
import Register from './pages/admin/Register'
import Login from './pages/admin/Login'
import Dashboard from './pages/Dashboard'
import Home from './pages/Index'
import Detail from './pages/Detail'
import Movie from './pages/Movie'
import Watch from './pages/Watch'

import Member from './pages/admin/member/Main'
import MemberList from './pages/admin/member/List'
import MemberCreate from './pages/admin/member/Create'
import MemberEdit from './pages/admin/member/Edit'
import MemberDetail from './pages/admin/member/Detail'

// Users
import User from './pages/admin/users/Main'
import UserList from './pages/admin/users/List'
import UserCreate from './pages/admin/users/Create'
import UserEdit from './pages/admin/users/Edit'
import UserDetail from './pages/admin/users/Detail'
// Tag
import Tag from './pages/admin/tags/Main'
import TagList from './pages/admin/tags/List'
import TagCreate from './pages/admin/tags/Create'
import TagEdit from './pages/admin/tags/Edit'
import TagDetail from './pages/admin/tags/Detail'
// Categories
import Category from './pages/admin/categories/Main'
import CategoryList from './pages/admin/categories/List'
import CategoryCreate from './pages/admin/categories/Create'
import CategoryEdit from './pages/admin/categories/Edit'
import CategoryDetail from './pages/admin/categories/Detail'

// Movies
import Movies from './pages/admin/movies/Main'
import MoviesList from './pages/admin/movies/List'
import MoviesCreate from './pages/admin/movies/Create'
import MoviesEdit from './pages/admin/movies/Edit'
import MoviesDetail from './pages/admin/movies/Detail'
// Routes
const routes = [
    // {
    //     path: '/',
    //     name: 'home',
    //     component: Dashboard,
    //     meta: {
    //         auth: undefined
    //     },
    //     children: [
    //         {
    //             path: '',
    //             name: '',
    //             component: Home,
    //         },
    //         {
    //             path: 'movie/:id',
    //             name: 'movie',
    //             component: Movie,
    //         },
    //         {
    //             path: 'watch/:id',
    //             name: 'movie.watch',
    //             component: Watch,
    //         },
    //     ],
    // },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // USER ROUTES
    {
        path: '/',
        name: 'dashboard',
        meta: {
            auth: true
        }
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: Index,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        },
        children: [{
            path: 'member',
            name: 'admin.member',
            component: Member,
            children: [{
                path: 'create',
                name: 'admin.member.create',
                component: MemberCreate,
            },
                {
                    path: 'list',
                    name: 'admin.member.list',
                    component: MemberList,
                },
                {
                    path: 'edit/:id',
                    name: 'admin.member.edit',
                    component: MemberEdit,
                },
                {
                    path: ':id',
                    name: 'admin.member.detail',
                    component: MemberDetail,
                },
            ],
        },
            {
                path: 'user',
                name: 'admin.user',
                component: User,
                children: [{
                    path: 'create',
                    name: 'admin.user.create',
                    component: UserCreate,
                },
                    {
                        path: 'list',
                        name: 'admin.user.list',
                        component: UserList,
                    },
                    {
                        path: 'edit/:id',
                        name: 'admin.user.edit',
                        component: UserEdit,
                    },
                    {
                        path: 'detail/:id',
                        name: 'admin.user.detail',
                        component: UserDetail,
                    },
                ],
            },
            {
                path: 'tag',
                name: 'admin.tag',
                component: Tag,
                children: [{
                    path: 'create',
                    name: 'admin.tag.create',
                    component: TagCreate,
                },
                    {
                        path: 'list',
                        name: 'admin.tag.list',
                        component: TagList,
                    },
                    {
                        path: 'edit/:id',
                        name: 'admin.tag.edit',
                        component: TagEdit,
                    },
                    {
                        path: 'detail/:id',
                        name: 'admin.tag.detail',
                        component: TagDetail,
                    },
                ],
            },
            {
                path: 'category',
                name: 'admin.category',
                component: Category,
                children: [{
                    path: 'create',
                    name: 'admin.category.create',
                    component: CategoryCreate,
                },
                    {
                        path: 'list',
                        name: 'admin.category.list',
                        component: CategoryList,
                    },
                    {
                        path: 'edit/:id',
                        name: 'admin.category.edit',
                        component: CategoryEdit,
                    },
                    {
                        path: 'detail/:id',
                        name: 'admin.category.detail',
                        component: CategoryDetail,
                    },
                ],
            },
            {
                path: 'movie',
                name: 'admin.movie',
                component: Movies,
                children: [{
                    path: 'create',
                    name: 'admin.movie.create',
                    component: MoviesCreate,
                },
                    {
                        path: 'list',
                        name: 'admin.movie.list',
                        component: MoviesList,
                    },
                    {
                        path: 'edit/:id',
                        name: 'admin.movie.edit',
                        component: MoviesEdit,
                    },
                    {
                        path: ':id',
                        name: 'admin.movie.detail',
                        component: MoviesDetail,
                    },
                ],
            },
        ]
    },
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
