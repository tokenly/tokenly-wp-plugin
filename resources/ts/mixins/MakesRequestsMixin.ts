import { injectable } from "inversify";

declare const wpApiSettings: any;

@injectable()
export class MakesRequestsMixin {
	namespace = '/wp-json/tokenly/v1/';

	get headers() {
		return {
			'Content-type': 'application/json; charset=UTF-8',
			'X-WP-Nonce': wpApiSettings.nonce,
		}
	}
}
