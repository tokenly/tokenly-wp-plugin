import App from "../App";
import { container } from "./Inversify.config";
import '../../scss/Frontend.scss';
import { TYPES } from './Types';
import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


class FrontendApp extends App {
	constructor() {
		super( container );
	}

	get providers() {
		return [
			TYPES.Providers.ComponentServiceProviderInterface,
		] as Array<any>;
	}
}	

( function() {
	const frontend = new FrontendApp();	
	  // init Swiper:
	const swiper = new Swiper('.swiper', {
		slidesPerView: 3,
		spaceBetween: 40,
		modules: [Navigation, Pagination],
		loop: false,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});
} )();

