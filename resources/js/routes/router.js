
import Login from "../page/Login";
import Home from "../page/Home";
import About from "../page/About";
import guest from './middleware/guest'
import auth from './middleware/auth'


const routes = [
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                middleware: [
                    guest
                ]
            }
        },
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                middleware: [
                    auth
                ]
            }
        },
        {
            path: '/about',
            name: 'about',
            component:About,
            meta: {
                middleware: [
                    auth
                ]
            }
        }
];

export default routes;
