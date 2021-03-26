import emails from './emails.vue';
import email from './email.vue';
 
export const routes = [
    {
        name: 'home',
        path: '/',
        component: emails
    },
    {
        name: 'email',
        path: '/email/:id',
        component: email
    }
];