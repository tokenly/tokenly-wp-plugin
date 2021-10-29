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

// API Interfaces
