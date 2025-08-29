import { usePage } from "@inertiajs/vue3";

/**
 * Check if the authenticated user has one of the specified roles.
 *
 * @param {Array} roles - An array of roles to check.
 * @returns {Boolean} - True if the user has one of the roles, false otherwise.
 */
export const HasRole = (roles) => {
    const { props } = usePage(); // Access Inertia props
    const auth = props.auth; // Auth data from Laravel

    if (!auth || !auth.user || !auth.user.role_type) {
        return false; // No authenticated user or no role defined
    }

    return roles.includes(auth.user.role_type);
};