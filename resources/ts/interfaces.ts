export interface Provider {
	register(): void;
}

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
	type: string;
	assets: string;
}

export interface WhitelistItem {
	address: string;
	index: string;
}

export interface WhitelistData {
	use_whitelist: boolean;
	whitelist: Array<WhitelistItem>;
}

export interface SourceData {
	address: string,
	assets: string,
}

export interface TokenMetaData {
	asset: string;
}

export interface UserSuggestion {
	id: number;
	name: string;
}

export interface PromiseData {
	//
}

// API Interfaces

export interface UserShowParams {
	id: number,
}

export interface UserIndexParams {
	name: string,
}

export interface PromiseStoreParams {
	source: string;
	destination: number;
	asset: string;
	quantity: number;
	ref: string;
	note: string;
}
