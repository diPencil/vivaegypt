<?php

/**
 * Dev admin: full access to the admin panel like super admin.
 * Super admin cannot open dev-only tooling (Theme / Menu management) — see DevAdminExclusiveRoutes
 * and dev_admin_exclusive_path_prefixes below.
 */
return [

    /**
     * @deprecated Removed with RestrictDevAdmin middleware — kept empty for backward compatibility
     *            if anything still reads these keys.
     */
    'dev_admin_blocked_path_prefixes' => [],

    /**
     * @deprecated No longer used.
     */
    'dev_admin_allowed_paths' => [],

    /**
     * Only dev_admin can open these URL prefixes (hidden from super admin in sidebar + 403 if forced).
     */
    'dev_admin_exclusive_path_prefixes' => [
        'admin/themes',
        'admin/menus',
        'admin/menu-items',
    ],

    /**
     * Staff roles introduced for operational access.
     */
    'staff_roles' => [
        'staff_data_entry',
        'staff_accountant',
        'agent_travel',
        'agent_sales',
        'agent_booking',
    ],

    /**
     * Action-level permissions available to staff UI and routes.
     */
    'staff_allowed_actions' => [
        'view',
        'create',
        'edit',
        'update_status',
        'export',
        'import',
        'approve',
        'reject',
    ],

    /**
     * Canonical permission groups used by the staff role matrix.
     * Each key maps to one or more admin route patterns and a sidebar section.
     */
    'staff_permission_groups' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'section' => 'dashboard',
            'routes' => ['admin.dashboard', 'admin.logout'],
        ],
        'booking_services' => [
            'label' => 'Booking Services',
            'section' => 'booking_services',
            'routes' => [
                'admin.tourbooking.services.index',
                'admin.tourbooking.services.create',
                'admin.tourbooking.services.store',
                'admin.tourbooking.services.show',
                'admin.tourbooking.services.edit',
                'admin.tourbooking.services.update',
                'admin.tourbooking.services.by-type',
                'admin.tourbooking.services.tours',
                'admin.tourbooking.services.hotels',
                'admin.tourbooking.services.restaurants',
                'admin.tourbooking.services.rentals',
                'admin.tourbooking.services.activities',
                'admin.tourbooking.services.media',
                'admin.tourbooking.services.media.store',
                'admin.tourbooking.services.media.destroy',
                'admin.tourbooking.services.media.set-thumbnail',
                'admin.tourbooking.services.itineraries',
                'admin.tourbooking.services.itineraries.store',
                'admin.tourbooking.services.itineraries.update',
                'admin.tourbooking.services.itineraries.destroy',
                'admin.tourbooking.services.extra-charges',
                'admin.tourbooking.services.extra-charges.store',
                'admin.tourbooking.services.extra-charges.update',
                'admin.tourbooking.services.extra-charges.destroy',
                'admin.tourbooking.services.availability',
                'admin.tourbooking.services.availability.store',
                'admin.tourbooking.services.availability.update',
                'admin.tourbooking.services.availability.destroy',
                'admin.tourbooking.service-types.*',
                'admin.tourbooking.amenities.*',
            ],
        ],
        'destinations' => [
            'label' => 'Destinations',
            'section' => 'destinations',
            'routes' => [
                'admin.tourbooking.destinations.*',
                'admin.tourbooking.destinations.update-status',
                'admin.tourbooking.destinations.update-featured',
            ],
        ],
        'products' => [
            'label' => 'Manage Product',
            'section' => 'products',
            'routes' => [
                'admin.product.*',
                'admin.brand.*',
                'admin.category.*',
                'admin.sub-category.*',
                'admin.product.review.list',
            ],
        ],
        'explores' => [
            'label' => 'Manage Explores',
            'section' => 'explores',
            'routes' => [
                'admin.blog.*',
                'admin.blog-category.*',
                'admin.comment-list',
                'admin.show-comment',
            ],
        ],
        'pages' => [
            'label' => 'Manage Pages',
            'section' => 'pages',
            'routes' => [
                'admin.terms-conditions',
                'admin.update-terms-conditions',
                'admin.privacy-policy',
                'admin.update-privacy-policy',
                'admin.contact-us',
                'admin.update-contact-us',
                'admin.custom-page.*',
                'admin.faq.*',
            ],
        ],
        'content' => [
            'label' => 'Manage Content',
            'section' => 'content',
            'routes' => [
                'admin.front-end.*',
                'admin.footer',
                'admin.testimonial.*',
                'admin.partner.*',
            ],
        ],
        'settings' => [
            'label' => 'Setting & Configuration',
            'section' => 'settings',
            'routes' => [
                'admin.multi-currency.*',
                'admin.language.*',
                'admin.theme-language',
                'admin.update-theme-language',
                'admin.seo-setting',
                'admin.update-seo-setting',
            ],
        ],
        'users' => [
            'label' => 'Manage Users',
            'section' => 'users',
            'routes' => [
                'admin.user-list',
                'admin.pending-user',
                'admin.user-show',
                'admin.user-status',
                'admin.user-update',
                'admin.user-create',
                'admin.user-store',
                'admin.user-login-as',
                'admin.user-delete',
            ],
        ],
        'agents' => [
            'label' => 'Manage Seller',
            'section' => 'agents',
            'routes' => [
                'admin.seller-list',
                'admin.pending-seller',
                'admin.seller-show',
                'admin.agent-create',
                'admin.agent-store',
                'admin.seller-joining-request',
                'admin.seller-joining-detail',
                'admin.seller-joining-approval',
                'admin.seller-joining-reject',
            ],
        ],
        'orders' => [
            'label' => 'Manage Order',
            'section' => 'orders',
            'routes' => [
                'admin.orders',
                'admin.order',
                'admin.active-orders',
                'admin.reject-orders',
                'admin.delivered-orders',
                'admin.complete-orders',
                'admin.pending-payment-orders',
            ],
        ],
        'bookings' => [
            'label' => 'Manage Bookings',
            'section' => 'bookings',
            'routes' => [
                'admin.tourbooking.bookings.*',
            ],
        ],
        'finance' => [
            'label' => 'Financial Metrics',
            'section' => 'finance',
            'routes' => [
                'admin.withdraw-list.*',
                'admin.withdraw-methods.*',
                'admin.tourbooking.bookings.*',
            ],
        ],
        'support' => [
            'label' => 'Support Ticket',
            'section' => 'support',
            'routes' => [
                'admin.contact-message',
                'admin.show-message',
                'admin.support-tickets',
                'admin.support-ticket',
                'admin.live-chat.*',
            ],
        ],
        'withdraw' => [
            'label' => 'Manage Withdraw',
            'section' => 'withdraw',
            'routes' => [
                'admin.withdraw-methods.*',
                'admin.withdraw-list.*',
            ],
        ],
        'dev_tools' => [
            'label' => 'Theme Management',
            'section' => 'dev_tools',
            'routes' => [
                'admin.themes.*',
                'admin.menus.*',
                'admin.menu-items.*',
            ],
        ],
        'special_booking_catalog' => [
            'label' => 'Special Booking Catalog',
            'section' => 'special_bookings',
            'routes' => [
                'admin.special-booking.airlines.*',
                'admin.special-booking.transfer-vehicles.*',
                'admin.special-booking.nile-cruise-routes.*',
                'admin.special-booking.nile-cruise-cabins.*',
                'admin.special-booking.booking-features.*',
                'admin.special-booking.spa-services.*',
            ],
        ],
        'special_booking_requests' => [
            'label' => 'Special Booking Requests',
            'section' => 'special_bookings',
            'routes' => [
                'admin.special-booking.spa-bookings.*',
                'admin.special-booking.flight-requests.*',
                'admin.special-booking.transfer-requests.*',
                'admin.special-booking.nile-cruise-requests.*',
            ],
        ],
    ],

    /**
     * Default selected permission keys for each staff role.
     */
    'staff_default_permissions' => [
        'staff_data_entry' => ['dashboard', 'booking_services', 'destinations', 'products', 'explores', 'pages', 'content', 'settings', 'special_booking_catalog'],
        'staff_accountant' => ['dashboard', 'users', 'agents', 'orders', 'support', 'withdraw', 'bookings', 'finance', 'special_booking_requests'],
        'agent_travel' => ['dashboard', 'users', 'agents', 'orders', 'support', 'bookings', 'special_booking_requests'],
        'agent_sales' => ['dashboard', 'users', 'agents', 'orders', 'support', 'products', 'bookings', 'special_booking_requests'],
        'agent_booking' => ['dashboard', 'users', 'agents', 'orders', 'support', 'bookings', 'special_booking_requests'],
    ],

    /**
     * Sidebar sections that staff roles are allowed to see.
     */
    'staff_sidebar_sections' => [
        'staff_data_entry' => [
            'dashboard',
            'operations',
            'product-review',
            'cms',
            'settings',
            'special_bookings',
        ],
        'staff_accountant' => [
            'dashboard',
            'users',
            'agents',
            'operations',
            'orders',
            'withdraw',
            'support',
            'special_bookings',
        ],
        'agent_travel' => [
            'dashboard',
            'users',
            'agents',
            'operations',
            'orders',
            'support',
            'special_bookings',
        ],
        'agent_sales' => [
            'dashboard',
            'users',
            'agents',
            'operations',
            'orders',
            'product-review',
            'support',
            'special_bookings',
        ],
        'agent_booking' => [
            'dashboard',
            'users',
            'agents',
            'operations',
            'orders',
            'support',
            'special_bookings',
        ],
    ],

    /**
     * Route name policy for staff roles.
     */
    'staff_route_policy' => [
        'staff_data_entry' => [
            'allow' => [
                'admin.dashboard',
                'admin.logout',
                'admin.user-list',
                'admin.pending-user',
                'admin.user-show',
                'admin.user-status',
                'admin.user-update',
                'admin.user-login-as',
                'admin.seller-list',
                'admin.pending-seller',
                'admin.seller-show',
                'admin.seller-joining-request',
                'admin.seller-joining-detail',
                'admin.orders',
                'admin.order',
                'admin.active-orders',
                'admin.reject-orders',
                'admin.delivered-orders',
                'admin.complete-orders',
                'admin.pending-payment-orders',
                'admin.contact-message',
                'admin.show-message',
                'admin.support-tickets',
                'admin.support-ticket',
                'admin.live-chat.*',
                'admin.product.*',
                'admin.brand.*',
                'admin.category.*',
                'admin.sub-category.*',
                'admin.blog.*',
                'admin.blog-category.*',
                'admin.comment-list',
                'admin.show-comment',
                'admin.page.*',
                'admin.faq.*',
                'admin.testimonial.*',
                'admin.shipping-method.index',
                'admin.special-booking.airlines.*',
                'admin.special-booking.transfer-vehicles.*',
                'admin.special-booking.nile-cruise-routes.*',
                'admin.special-booking.nile-cruise-cabins.*',
                'admin.special-booking.booking-features.*',
                'admin.special-booking.spa-services.*',
            ],
            'deny' => [
                'admin.*delete*',
                'admin.*destroy*',
                'admin.themes.*',
                'admin.menus.*',
                'admin.menu-items.*',
                'admin.language.*',
                'admin.theme-language',
                'admin.email-setting',
                'admin.email-template',
                'admin.cookie-consent',
                'admin.error-image',
                'admin.login-image',
                'admin.admin-login-image',
                'admin.breadcrumb',
                'admin.social-login',
                'admin.default-avatar',
                'admin.maintenance-mode',
                'admin.general-setting*',
                'admin.global-setting*',
                'admin.withdraw-methods.*',
                'admin.withdraw-list.*',
                'admin.special-booking.spa-bookings.*',
                'admin.special-booking.flight-requests.*',
                'admin.special-booking.transfer-requests.*',
                'admin.special-booking.nile-cruise-requests.*',
            ],
        ],
        'staff_accountant' => [
            'allow' => [
                'admin.dashboard',
                'admin.logout',
                'admin.user-list',
                'admin.pending-user',
                'admin.user-show',
                'admin.user-status',
                'admin.user-update',
                'admin.user-login-as',
                'admin.seller-list',
                'admin.pending-seller',
                'admin.seller-show',
                'admin.seller-joining-request',
                'admin.seller-joining-detail',
                'admin.orders',
                'admin.order',
                'admin.active-orders',
                'admin.reject-orders',
                'admin.delivered-orders',
                'admin.complete-orders',
                'admin.pending-payment-orders',
                'admin.tourbooking.bookings.*',
                'admin.contact-message',
                'admin.show-message',
                'admin.support-tickets',
                'admin.support-ticket',
                'admin.live-chat.*',
                'admin.withdraw-methods.*',
                'admin.withdraw-list.*',
                'admin.special-booking.spa-bookings.*',
                'admin.special-booking.flight-requests.*',
                'admin.special-booking.transfer-requests.*',
                'admin.special-booking.nile-cruise-requests.*',
            ],
            'deny' => [
                'admin.*delete*',
                'admin.*destroy*',
                'admin.themes.*',
                'admin.menus.*',
                'admin.menu-items.*',
                'admin.language.*',
                'admin.theme-language',
                'admin.email-setting',
                'admin.email-template',
                'admin.cookie-consent',
                'admin.error-image',
                'admin.login-image',
                'admin.admin-login-image',
                'admin.breadcrumb',
                'admin.social-login',
                'admin.default-avatar',
                'admin.maintenance-mode',
                'admin.general-setting*',
                'admin.global-setting*',
                'admin.product.*',
                'admin.brand.*',
                'admin.category.*',
                'admin.sub-category.*',
                'admin.blog.*',
                'admin.blog-category.*',
                'admin.comment-list',
                'admin.show-comment',
                'admin.page.*',
                'admin.faq.*',
                'admin.testimonial.*',
                'admin.shipping-method.index',
                'admin.special-booking.airlines.*',
                'admin.special-booking.transfer-vehicles.*',
                'admin.special-booking.nile-cruise-routes.*',
                'admin.special-booking.nile-cruise-cabins.*',
                'admin.special-booking.booking-features.*',
                'admin.special-booking.spa-services.*',
            ],
        ],
    ],

];
