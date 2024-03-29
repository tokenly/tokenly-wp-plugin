import DictionaryInterface from "./Interfaces/DictionaryInterface"

export default class Dictionary implements DictionaryInterface {
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
            tokenSourceCardWhitelistLabel:
                'Whitelisted Assets:',
            settingsTitle:
                `${this.brand} Settings`,
            settingsIntegrationTitle:
                'Integration Settings',
            settingsIntegrationClientIdLabel:
                'Client ID',
            settingsIntegrationClientSecretLabel:
                'Client Secret',
            settingsIntegrationScopesTitle:
                'Extra Permissions.',
            settingsIntegrationScopesDescription:
                `Note: Enabling these features will request additional 
                permissions from the users upon login.`,
            settingsIntegrationScopesPrivateBalancesTitle:
                'Private Balances',
            settingsIntegrationScopesPrivateBalancesLabel:
                'Enable Private Balances',
            settingsIntegrationScopesPrivateBalancesDescription:
                `Allows to see and manage the balances from the pockets which
                 are not marked as public.`,
            settingsIntegrationScopesPrivateAddressesTitle:
                'Private Addresses',
            settingsIntegrationScopesPrivateAddressesLabel:
                'Enable Private Addresses',
            settingsIntegrationScopesPrivateAddressesDescription:
                `Allows to see and manage the addresses which are not marked 
                as public.`,
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

    get( key: string ): string {
        return this.items[ key ] ?? ''
    }
}