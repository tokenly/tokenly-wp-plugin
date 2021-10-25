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