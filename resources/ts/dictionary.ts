export default class Dictionary {
    protected brand?: string

    constructor(brand: string) {
        this.brand = brand
    }

    get items(): any {
        return {
            dashboardTitle: 
                `${this.brand} Dashboard`,
            dashboardDashboardMenuItemTitle: 
                'Main Dashboard',
            dashboardDashboardMenuItemDescription: 
                `${this.brand} main dashboard (external)`,
            dashboardInventoryMenuItemTitle: 
                'Profile',
            dashboardInventoryMenuItemDescription:
                'Manage Connection and User Settings.',
            dashboardTokenVendorMenuItemTitle:
                'Token Vendor',
            dashboardTokenVendorMenuItemDescription:
                'Manage token assets.',
            dashboardCreditVendorMenuItemTitle:
                'Credit Vendor',
            dashboardCreditVendorMenuItemDescription:
                'Manage credit groups and transactions.',
            dashboardSettingsMenuItemTitle:
                'Settings',
            dashboardSettingsMenuItemDescription:
                'Manage plugin settings.',
            creditVendorTitle:
                'Credit Vendor',
            creditVendorGroupsMenuItemTitle:
                'Groups and Transactions',
            creditVendorGroupsMenuItemDescription:
                'View and manage credit groups and their transactions.',
            creditVendorWhitelistMenuItemTitle:
                'Whitelist',
            creditVendorWhitelistMenuItemDescription:
                `View and manage the list of groups allowed for viewing 
                and transactions.`,
            creditGroupAccountIndexTitle:
                'Group Account Listing',
            creditGroupAccountIndexSectionTitle:
                'Registered Accounts',
            tokenVendorTitle:
                'Token Vendor',
            tokenVendorPromisesMenuItemTitle:
                'Promises',
            tokenVendorPromisesMenuItemDescription:
                'View and manage token promises.',
            tokenVendorWhitelistMenuItemTitle:
                'Whitelist',
            tokenVendorWhitelistMenuItemDescription:
                `View and manage the list of assets allowed for viewing 
                and transactions.`,
            tokenVendorSourcesMenuItemTitle:
                'Sources',
            tokenVendorSourcesMenuItemDescription:
                'View and manage sources for promise transactions.',
            tokenVendorAddressesMenuItemTitle:
                'Addresses',
            tokenVendorAddressesMenuItemDescription:
                'View and manage addresses for promise transactions.',
            tokenVendorMetaMenuItemTitle:
                'Meta',
            tokenVendorMetaMenuItemDescription:
                `View and manage additional information about the token 
                assets.`,
            tokenVendorCategoriesMenuItemTitle:
                'Categories',
            tokenVendorCategoriesMenuItemDescription:
                'View and manage token categories.',
            settingsTitle:
                `${this.brand} Settings`,
            settingsIntegrationTitle:
                'Integration Settings',
            settingsIntegrationSave:
                'Save Integration Settings',
            settingsTcaTitle:
                'Token Controlled Access (TCA)',
            settingsTcaSave:
                'Save Integration Settings',
            settingsOauthTitle:
                'Authorization (OAuth)',
            settingsOauthSave:
                'Save OAuth Settings',
            userCreditBalanceTitle:
                'User Credit Balance Listing',
            userTokenBalanceTitle:
                'User Token Balance Listing',
            userBalanceSectionTitle:
                'Balance Listing',
        }
    }

    get( key: string ) {
        return this.items[ key ] ?? ''
    }
}