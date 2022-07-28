import NotFound from './components/NotFound';
import Welcome from './components/Welcome';
import AboutUs from './components/AboutUs';
import ContactUs from './components/ContactUs';
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
import AdminVideoRollsList from './components/admin/AdminVideoRollsList';
import AdminVideoRollsDetail from './components/admin/AdminVideoRollsDetail';
import AdminNewsletterUsersList from './components/admin/AdminNewsletterUsersList';
import AdminCreateNewsletter from './components/admin/AdminCreateNewsletter';
import AdminNewslettersList from './components/admin/AdminNewslettersList';
import AdminNewslettersDetail from './components/admin/AdminNewslettersDetail';
import UserEmailConfirmation from './components/user/UserEmailConfirmation';
import StaffRegister from './components/user/StaffRegister';
import AdminUserDetail from './components/admin/AdminUserDetail';
import AdminUpdateUser from './components/admin/AdminUpdateUser';
import AdminPropertyDetail from './components/admin/AdminPropertyDetail';
import AdminPropertyUpdate from './components/admin/AdminPropertyUpdate';
import AdminPropertyPlanUpdate from './components/admin/AdminPropertyPlanUpdate';
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
import AdminUpdateNewsPost from './components/admin/AdminUpdateNewsPost';
import AdminNewsPostSearchResult from './components/admin/AdminNewsPostSearchResult';
import AdminProfile from './components/admin/AdminProfile';
import AdminPropertySearchResult from './components/admin/AdminPropertySearchResult';
import AdminPasswordResets from './components/admin/AdminPasswordResets';
import AdminEnquiries from './components/admin/AdminEnquiries';
import AdminEnquiryDetail from './components/admin/AdminEnquiryDetail';
import AdminEnquirySearchResult from './components/admin/AdminEnquirySearchResult';
import AdminNewOffersList from './components/admin/AdminNewOffersList';
import AdminNewOfferDetail from './components/admin/AdminNewOfferDetail';
import AdminNewOfferSearchResult from './components/admin/AdminNewOfferSearchResult';
import AdminFaqDetail from './components/admin/AdminFaqDetail';
import AdminFaqList from './components/admin/AdminFaqList';
import StaffDashboard from './components/user/StaffDashboard';
import StaffPropertyList from './components/user/StaffPropertyList';
import StaffPropertySearchResult from './components/user/StaffPropertySearchResult';
import StaffPropertyDetail from './components/user/StaffPropertyDetail';
import StaffPropertyUpdate from './components/user/StaffPropertyUpdate';
import StaffCreateListing from './components/user/StaffCreateListing';
import StaffCreateListingUploads from './components/user/StaffCreateListingUploads';
import StaffSubscriptionsList from './components/user/StaffSubscriptionsList';
import StaffSubscriptionDetail from './components/user/StaffSubscriptionDetail';
import StaffSubscriptionSearchResult from './components/user/StaffSubscriptionSearchResult';
import StaffCreatePropertyPlans from './components/user/StaffCreatePropertyPlans';
import StaffPropertyPlanUpdate from './components/user/StaffPropertyPlanUpdate';
import StaffEventsList from './components/user/StaffEventsList';
import StaffEventDetail from './components/user/StaffEventDetail';
import StaffUpdateEvent from './components/user/StaffUpdateEvent';
import StaffNewsList from './components/user/StaffNewsList';
import StaffNewsPostDetail from './components/user/StaffNewsPostDetail';
import StaffUpdateNewsPost from './components/user/StaffUpdateNewsPost';
import StaffCreateNewsPost from './components/user/StaffCreateNewsPost';
import StaffNewsPostSearchResult from './components/user/StaffNewsPostSearchResult';
import StaffCreateEvent from './components/user/StaffCreateEvent';
import StaffCreateEventUpload from './components/user/StaffCreateEventUpload';
import StaffEventSearchResult from './components/user/StaffEventSearchResult';
import StaffNewOffers from './components/user/StaffNewOffers';
import StaffCreateNewOffer from './components/user/StaffCreateNewOffer';
import StaffNewOfferDetail from './components/user/StaffNewOfferDetail';
import StaffOfferEdit from './components/user/StaffOfferEdit';
import StaffVideoRollList from './components/user/StaffVideoRollList';
import StaffCreateVideoRoll from './components/user/StaffCreateVideoRoll';
import StaffVideoRollDetail from './components/user/StaffVideoRollDetail';
import StaffUpdateVideoRoll from './components/user/StaffUpdateVideoRoll';
import StaffVideoRollSearchResult from './components/user/StaffVideoRollSearchResult';
import StaffFaqList from './components/user/StaffFaqList';
import StaffFaqDetail from './components/user/StaffFaqDetail';
import StaffFaqUpdate from './components/user/StaffFaqUpdate';
import StaffCreateFAQ from './components/user/StaffCreateFAQ';
import StaffProfile from './components/user/StaffProfile';
import Testimonials from './components/Testimonials';
import CreateTestimonial from './components/CreateTestimonial';
import TestimonialSent from './components/TestimonialSent';
import ForgotPassword from './components/ForgotPassword';
import PasswordReset from './components/PasswordReset';
import PasswordHasBeenReset from './components/PasswordHasBeenReset';
import AllEvents from './components/Events';
import EventDetail from './components/EventDetail';
import AllNewsPost from './components/NewsPosts';
import NewsPostDetail from './components/NewsPostDetail';
import AllListings from './components/AllListings';
import PropertyListingDetail from './components/PropertyListingDetail';
import AllVideos from './components/AllVideos';
import FAQ from './components/Faq';
import Chart from './components/Chart';
import TermsAndConditions from './components/TermsAndConditions'


export default [
    {path: '*', name: 'NotFound', component: NotFound},
    { path: '/', name: 'Welcome', component: Welcome },
    { path: '/about-us', name: 'AboutUs', component: AboutUs },
    { path: '/contact-us', name: 'ContactUs', component: ContactUs },
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
        path: '/admin/users/update/:id', name: 'AdminUpdateUser', component: AdminUpdateUser,
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
        path: '/admin/listings/search', name: 'AdminPropertySearchResult', component: AdminPropertySearchResult, props: true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/listing-plan/update/:id', name: 'AdminPropertyPlanUpdate', component: AdminPropertyPlanUpdate,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/listings/update/:id', name: 'AdminPropertyUpdate', component: AdminPropertyUpdate,
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
        path: '/admin/news/search', name: 'AdminNewsPostSearchResult', component: AdminNewsPostSearchResult, props: true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/news/update/:id', name: 'AdminUpdateNewsPost', component: AdminUpdateNewsPost,
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
    {
        path: '/admin/password-resets', name: 'AdminPasswordResets', component: AdminPasswordResets,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/enquiries/search', name: 'AdminEnquirySearchResult', component: AdminEnquirySearchResult, props:true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/enquiries/:id', name: 'AdminEnquiryDetail', component: AdminEnquiryDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/enquiries', name: 'AdminEnquiries', component: AdminEnquiries,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/new-offers/search', name: 'AdminNewOfferSearchResult', component: AdminNewOfferSearchResult, props: true,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/new-offers/:id', name: 'AdminNewOfferDetail', component: AdminNewOfferDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/new-offers', name: 'AdminNewOffersList', component: AdminNewOffersList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/video-rolls/:id', name: 'AdminVideoRollsDetail', component: AdminVideoRollsDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/video-rolls', name: 'AdminVideoRollsList', component: AdminVideoRollsList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/newsletter-subscribers', name: 'AdminNewsletterUsersList', component: AdminNewsletterUsersList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/create-newsletter', name: 'AdminCreateNewsletter', component: AdminCreateNewsletter,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/newsletters/:id', name: 'AdminNewslettersDetail', component: AdminNewslettersDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/newsletters', name: 'AdminNewslettersList', component: AdminNewslettersList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/faqs/:id', name: 'AdminFaqDetail', component: AdminFaqDetail,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/faqs', name: 'AdminFaqList', component: AdminFaqList,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/admin/profile', name: 'AdminProfile', component: AdminProfile,
        meta: {
            requireAdminsAuth: true
        },
    },
    {
        path: '/staff/profile', name: 'StaffProfile', component: StaffProfile,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listing-plan/create-new/:listing', name: 'StaffCreatePropertyPlans', component: StaffCreatePropertyPlans,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listing-plan/update/:id', name: 'StaffPropertyPlanUpdate', component: StaffPropertyPlanUpdate,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/subscriptions/search', name: 'StaffSubscriptionSearchResult', component: StaffSubscriptionSearchResult, props: true,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/subscriptions/:id', name: 'StaffSubscriptionDetail', component: StaffSubscriptionDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/subscriptions', name: 'StaffSubscriptionsList', component: StaffSubscriptionsList,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listing/create-listing-upload', name: 'StaffCreateListingUploads', component: StaffCreateListingUploads,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listing/create-new', name: 'StaffCreateListing', component: StaffCreateListing,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listings/search', name: 'StaffPropertySearchResult', component: StaffPropertySearchResult, props: true,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listings/update/:id', name: 'StaffPropertyUpdate', component: StaffPropertyUpdate,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listings/:id', name: 'StaffPropertyDetail', component: StaffPropertyDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/listings', name: 'StaffPropertyList', component: StaffPropertyList,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events/search', name: 'StaffEventSearchResult', component: StaffEventSearchResult, prop: true,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events/create-new/:id/upload', name: 'StaffCreateEventUpload', component: StaffCreateEventUpload,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events/create-new', name: 'StaffCreateEvent', component: StaffCreateEvent,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events/update/:id', name: 'StaffUpdateEvent', component: StaffUpdateEvent,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events/:id', name: 'StaffEventDetail', component: StaffEventDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/events', name: 'StaffEventsList', component: StaffEventsList,
        meta: {
            requiresAuth: true
        },
    },

    {
        path: '/staff/news/create-news-post', name: 'StaffCreateNewsPost', component: StaffCreateNewsPost,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/news/update/:id', name: 'StaffUpdateNewsPost', component: StaffUpdateNewsPost,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/news/search', name: 'StaffNewsPostSearchResult', component: StaffNewsPostSearchResult, props: true,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/news/:id', name: 'StaffNewsPostDetail', component: StaffNewsPostDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/news', name: 'StaffNewsList', component: StaffNewsList,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/new-offers', name: 'StaffNewOffers', component: StaffNewOffers,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/new-offer/update/:id', name: 'StaffOfferEdit', component: StaffOfferEdit,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/new-offer/:id', name: 'StaffNewOfferDetail', component: StaffNewOfferDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/new-offers/create', name: 'StaffCreateNewOffer', component: StaffCreateNewOffer,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/create-video-rolls', name: 'StaffCreateVideoRoll', component: StaffCreateVideoRoll,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/video-roll/update/:id', name: 'StaffUpdateVideoRoll', component: StaffUpdateVideoRoll,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/video-rolls/:id', name: 'StaffVideoRollDetail', component: StaffVideoRollDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/video-rolls/search', name: 'StaffVideoRollSearchResult', component: StaffVideoRollSearchResult,
        meta: {
            requiresAuth: true
        },
    },

    {
        path: '/staff/video-rolls', name: 'StaffVideoRollList', component: StaffVideoRollList,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff-dashboard', name: 'StaffDashboard', component: StaffDashboard,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/create-faq', name: 'StaffCreateFAQ', component: StaffCreateFAQ,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/update-faq/:id', name: 'StaffFaqUpdate', component: StaffFaqUpdate,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/faqs/:id', name: 'StaffFaqDetail', component: StaffFaqDetail,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/staff/faqs', name: 'StaffFaqList', component: StaffFaqList,
        meta: {
            requiresAuth: true
        },
    },
    { path: '/admin-email-confirmation', name: 'AdminEmailConfirmation', component: AdminEmailConfirmation, props: true },
    { path: '/staff-register', name: 'StaffRegister', component: StaffRegister },
    { path: '/staff-email-confirmation', name: 'UserEmailConfirmation', component: UserEmailConfirmation, props: true },
    { path: '/subscription-form', name: 'SubscriptionForm', component: SubscriptionForm},
    { path: '/subscription-form2', name: 'SubscriptionForm2', component: SubscriptionForm2},
    { path: '/subscription-form3', name: 'SubscriptionForm3', component: SubscriptionForm3},
    { path: '/testimonials', name: 'Testimonials', component: Testimonials},
    { path: '/create-testimonial', name: 'CreateTestimonial', component: CreateTestimonial},
    { path: '/testimonial-success', name: 'TestimonialSent', component: TestimonialSent},
    { path: '/forgot-password', name: 'ForgotPassword', component: ForgotPassword},
    { path: '/password-reset', name: 'PasswordReset', component: PasswordReset, props: true},
    { path: '/password-reset-success', name: 'PasswordHasBeenReset', component: PasswordHasBeenReset},
    { path: '/events', name: 'AllEvents', component: AllEvents},
    { path: '/event/:id/:slug', name: 'EventDetail', component: EventDetail},
    { path: '/news-posts/:id/:slug', name: 'NewsPostDetail', component: NewsPostDetail},
    { path: '/news-posts', name: 'AllNewsPost', component: AllNewsPost},
    { path: '/listings', name: 'AllListings', component: AllListings},
    { path: '/listing/:id/:slug', name: 'PropertyListingDetail', component: PropertyListingDetail},
    { path: '/video-rolls', name: 'AllVideos', component: AllVideos},
    { path: '/test', name: 'TestPage', component: TestPage},
    { path: '/faq', name: 'FAQ', component: FAQ},
    { path: '/terms-conditions', name: 'TermsAndConditions', component: TermsAndConditions},
    { path: '/chart', name: 'Chart', component: Chart},
]
