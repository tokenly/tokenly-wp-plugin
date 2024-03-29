export interface AddressEditData {
	//
}

export interface Redirect {
	from: string
	to: string
}

export interface Component {
	element: HTMLElement
	register( selector: string ): void
}

export interface IntegrationSettings {
	client_id: string
	client_secret: string
}

export interface TcaSettings {
	post_types: object
	taxonomies: object
	filter_menu_items: boolean
	filter_post_results: boolean
}

export interface OauthSettings {
	use_single_sign_on: boolean
	success_url: string
	allow_no_email: boolean
	allow_unconfirmed_email: boolean
}

export interface SourceItem {
	address_id: string
	address: any
	type: string
	assets: Array<string>
}

export interface SourceStoreParams {
	address: string
	type: string
	assets: string
}

export interface WhitelistItem {
	address: string
	index: string
}

export interface WhitelistData {
	enabled: boolean
	items: Array<WhitelistItem>
}

export interface SourceData {
	address_id: string
	address?: any
	assets: string
}

export interface TokenMetaData {
	asset: string
	extra: any
}

export interface UserSuggestion {
	id: number
	name: string
}

export interface UserShowParams {
	id: number
}

export interface UserIndexParams {
	suggestions: boolean
	name: string
}

export interface PromiseStoreParams {
	source_id: string
	destination: number
	asset: string
	quantity: number
	pseudo: boolean
	ref: string
	note: string
}

export interface PromiseUpdateParams {
	quantity: number
	expiration: Date
	txid: string
	fingerprint: number
	ref: string
	note: string
}

export interface PromiseData {
	source_id: string
	source?: SourceData
	destination: string
	asset: string
	quantity: Quantity
	ref: string
	txid: string
	fingerprint: string
	expiration: number
	created_at: Date
	updated_at:	Date
	pseudo: boolean
	note: string
	promise_id: number
	promise_meta: any
}

export interface Quantity {
	value: number
	value_sat: number
	precision: number
}

export interface StatusData {
	status: boolean
}

export interface Redirect {
	from: string
	to: string
} 

export interface ConfirmModalData {
	key: string
	title: string
	subtitle: string
}

export interface Attribute {
	key: string
	value: string
}

export interface AuthData {
	status: boolean,
}

export interface ComponentData {
	name: string,
	selector: string,
}
