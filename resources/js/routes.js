import NotFound from './components/NotFound';
import Welcome from './components/Welcome';
import OurServices from './components/OurServices';
import AboutUs from './components/AboutUs';
import ContactUs from './components/ContactUs';
import Blog from './components/Blog';
import News from './components/News';
import Events from './components/Events';
import StaffLogin from './components/StaffLogin';
import AdminLogin from './components/admin/AdminLogin';
import AdminDashboard from './components/admin/AdminDashboard';
import AdminList from './components/admin/AdminList';
import AdminUsersList from './components/admin/AdminUsersList';
import AdminPropertyList from './components/admin/AdminPropertyList';
import AdminEventsList from './components/admin/AdminEventsList';
import AdminDetail from './components/admin/AdminDetail';
import AdminUpdateSuperUser from './components/admin/AdminUpdateSuperUser';
import AdminCreateSuperUser from './components/admin/AdminCreateSuperUser';
import AdminEmailConfirmation from './components/admin/AdminEmailConfirmation';
import UserEmailConfirmation from './components/user/UserEmailConfirmation';
import StaffRegister from './components/user/StaffRegister';
import AdminUserDetail from './components/admin/AdminUserDetail';
import AdminUpdateUser from './components/admin/AdminUpdateUser';
import AdminPropertyDetail from './components/admin/AdminPropertyDetail';
import AdminPropertyUpdate from './components/admin/AdminPropertyUpdate';
import SubscriptionForm from './components/SubscriptionForm';
import SubscriptionForm2 from './components/SubscriptionForm2';
import SubscriptionForm3 from './components/SubscriptionForm3';
import AdminSubscriptionList from './components/admin/AdminSubscriptionList';
import AdminSubscriptionDetail from './components/admin/AdminSubscriptionDetail';
import TestPage from './components/TestPage';
import AdminUpdateEvent from './components/admin/AdminEventUpdate';
import AdminEventDetail from './components/admin/AdminEventDetail';
import AdminEventSearchResult from './components/admin/AdminEventSearchResult';
import AdminTestimonialList from './components/admin/AdminTestimonialList';
import AdminTestimonialSearchResult from './components/admin/AdminTestimonialSearchResult';
import AdminTestimonialDetail from './components/admin/AdminTestimonialDetail';
import AdminUpdateTestimonial from './components/admin/AdminUpdateTestimonial';
import AdminNewsList from './components/admin/AdminNewsList';
import AdminNewsPostDetail from './components/admin/AdminNewsPostDetail';


export default [
    {path: '*', name: 'NotFound', component: NotFound},
    { path: '/', name: 'Welcome', component: Welcome },
    { path: '/our-services', name: 'OurServices', component: OurServices },
    { path: '/about-us', name: 'AboutUs', component: AboutUs },
    { path: '/contact-us', name: 'ContactUs', component: ContactUs },
    { path: '/blog', name: 'Blog', component: Blog },
    { path: '/news', name: 'News', component: News },
    { path: '/events', name: 'Events', component: Events },
    { path: '/login', name: 'StaffLogin', component: StaffLogin },
    { path: '/admin-login', name: 'AdminLogin', component: AdminLogin },
    {
        path: '/admin', name: 'AdminDashboard', component: AdminDashboard,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/superusers', name: 'AdminList', component: AdminList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/superusers/:id', name: 'AdminDetail', component: AdminDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/superusers/:id/update', name: 'AdminUpdateSuperUser', component: AdminUpdateSuperUser,
        meta: {
            requireAdminsAuth: true
        }
    },
    {
        path: '/admin/create-superuser', name: 'AdminCreateSuperUser', component: AdminCreateSuperUser,
        meta: {
            requireAdminsAuth: true
        }
    },
    {
        path: '/admin/users/:id/update', name: 'AdminUpdateUser', component: AdminUpdateUser,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/users/:id/:user_id', name: 'AdminUserDetail', component: AdminUserDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/users', name: 'AdminUsersList', component: AdminUsersList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/listings/:id/update', name: 'AdminPropertyUpdate', component: AdminPropertyUpdate,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/listings/:id', name: 'AdminPropertyDetail', component: AdminPropertyDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/listings', name: 'AdminPropertyList', component: AdminPropertyList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/subscriptions/:id', name: 'AdminSubscriptionDetail', component: AdminSubscriptionDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/subscriptions', name: 'AdminSubscriptionList', component: AdminSubscriptionList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/events/update/:id', name: 'AdminUpdateEvent', component: AdminUpdateEvent,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/events/search', name: 'AdminEventSearchResult', component: AdminEventSearchResult, props: true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/events/:id', name: 'AdminEventDetail', component: AdminEventDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/events', name: 'AdminEventsList', component: AdminEventsList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/testimonials/:id', name: 'AdminTestimonialDetail', component: AdminTestimonialDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/testimonials/update/:id', name: 'AdminUpdateTestimonial', component: AdminUpdateTestimonial,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/testimonials/search', name: 'AdminTestimonialSearchResult', component: AdminTestimonialSearchResult, props: true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/testimonials', name: 'AdminTestimonialList', component: AdminTestimonialList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/news/:id', name: 'AdminNewsPostDetail', component: AdminNewsPostDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/news', name: 'AdminNewsList', component: AdminNewsList,
        meta: {
            requireAdminsAuth: true
        },
    },
    { path: '/admin-email-confirmation', name: 'AdminEmailConfirmation', component: AdminEmailConfirmation, props: true },
    { path: '/staff-register', name: 'StaffRegister', component: StaffRegister },
    { path: '/staff-email-confirmation', name: 'UserEmailConfirmation', component: UserEmailConfirmation, props: true },
    { path: '/subscription-form', name: 'SubscriptionForm', component: SubscriptionForm},
    { path: '/subscription-form2', name: 'SubscriptionForm2', component: SubscriptionForm2},
    { path: '/subscription-form3', name: 'SubscriptionForm3', component: SubscriptionForm3},
    { path: '/test', name: 'TestPage', component: TestPage},

]
