export interface Redirect {
	from: string;
	to: string;
}

export interface Component {
	element: HTMLElement;
	register( selector: string ): void;
}

export interface SettingsData {
	client_id: string;
	client_secret: string;
}

export interface SourceItem {
	address: string;
	address_data: any;
	type: string;
	assets: Array<string>;
}

export interface SourceStoreParams {
	address: string;
	type: string;
	assets: string;
}

export interface WhitelistItem {
	address: string;
	index: string;
}

export interface WhitelistData {
	enabled: boolean;
	items: Array<WhitelistItem>;
}

export interface SourceData {
	address: string;
	assets: string;
}

export interface TokenMetaData {
	asset: string;
	extra: any;
}

export interface UserSuggestion {
	id: number;
	name: string;
}

export interface UserShowParams {
	id: number;
}

export interface UserIndexParams {
	suggestions: boolean;
	name: string;
}

export interface PromiseStoreParams {
	source: string;
	destination: number;
	asset: string;
	quantity: number;
	pseudo: boolean;
	ref: string;
	note: string;
}

export interface PromiseUpdateParams {
	quantity: number;
	expiration: Date;
	txid: string;
	fingerprint: number;
	ref: string;
	note: string;
}

export interface PromiseData {
	source: string;
	destination: string;
	asset: string;
	quantity: number;
	ref: string;
	txid: string;
	fingerprint: string;
	expiration: number;
	created_at: Date;
	updated_at:	Date;
	pseudo: boolean;
	note: string;
	promise_id: number;
	promise_meta: any;
}

export interface StatusData {
	status: boolean;
}

export interface Redirect {
	from: string;
	to: string;
} 

export interface ConfirmModalData {
	key: string;
	title: string;
	subtitle: string;
}

export interface Attribute {
	key: string;
	value: string;
}

export interface AuthData {
	status: boolean,
}

export interface ComponentData {
	name: string,
	selector: string,
}
