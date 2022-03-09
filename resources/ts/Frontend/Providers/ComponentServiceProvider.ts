import { injectable, inject, interfaces } from 'inversify';
import ServiceProvider from '../../Providers/ServiceProvider';
import ComponentServiceProviderInterface from '../Interfaces/Providers/ComponentServiceProviderInterface';
import { TYPES } from '../Types';
import LoginButtonComponentInterface from '../Interfaces/Components/LoginButtonComponentInterface';
// import SliderGalleryComponentFactoryInterface from '../Interfaces/Components/SliderGalleryComponentFactoryInterface';
import TokenBalanceComponentInterface from '../Interfaces/Components/Token/BalanceComponentInterface';
import TokenItemCardListComponentInterface from '../Interfaces/Components/Token/ItemCardListComponentInterface';
import CreditBalanceComponentInterface from '../Interfaces/Components/Credit/BalanceComponentInterface';
import CreditItemCardListComponentInterface from '../Interfaces/Components/Credit/ItemCardListComponentInterface';

@injectable()
export default class ComponentServiceProvider extends ServiceProvider implements ComponentServiceProviderInterface {
	components: any;
	factories : any;
	namespace: string;
	constructor(
		@inject( TYPES.Variables.namespace ) namespace: string,
		@inject( TYPES.Factories.LoginButtonComponentFactoryInterface) loginButtonComponentFactory: interfaces.AutoFactory<LoginButtonComponentInterface>,
		// @inject( TYPES.Factories.SliderGalleryComponentFactoryInterface) sliderGalleryComponentFactory: interfaces.AutoFactory<SliderGalleryComponentFactoryInterface>,
		@inject( TYPES.Factories.Token.BalanceComponentFactoryInterface) tokenBalanceComponentFactory: interfaces.AutoFactory<TokenBalanceComponentInterface>,
		@inject( TYPES.Factories.Token.ItemCardListComponentFactoryInterface) tokenItemCardListComponentFactory: interfaces.AutoFactory<TokenItemCardListComponentInterface>,
		@inject( TYPES.Factories.Credit.BalanceComponentFactoryInterface) creditBalanceComponentFactory: interfaces.AutoFactory<CreditBalanceComponentInterface>,
		@inject( TYPES.Factories.Credit.ItemCardListComponentFactoryInterface) creditItemCardListComponentFactory: interfaces.AutoFactory<CreditItemCardListComponentInterface>,
	) {
		super();
		this.namespace = namespace;
		this.components = [
			{
				name: 'loginButtonComponent',
				selector: `.${this.namespace}-login`,
				factory: loginButtonComponentFactory,
			},
			{
				name: 'tokenBalanceComponent',
				selector: `.${this.namespace}-token-balance`,
				factory: tokenBalanceComponentFactory,
			},
			{
				name: 'tokenItemCardListComponent',
				selector: `.${this.namespace}-token-item-card-list`,
				factory: tokenItemCardListComponentFactory,
			},
			{
				name: 'creditBalanceComponent',
				selector: `.${this.namespace}-credit-balance`,
				factory: creditBalanceComponentFactory,
			},
			{
				name: 'creditItemCardListComponent',
				selector: `.${this.namespace}-credit-item-card-list`,
				factory: creditItemCardListComponentFactory,
			},
			// {
			// 	name: 'sliderGalleryComponent',
			// 	selector: `.${this.namespace}-slider-gallery-component`,
			// 	factory: sliderGalleryComponentFactory,
			// },
		] as any;
	}
	
	register() {
		this.components.forEach( ( component: any ) => {
			const elements: NodeListOf<HTMLElement> = document.querySelectorAll( component.selector );
			elements.forEach( ( element: any ) => {
				const componentInstance = component.factory();
				componentInstance.element = element;
				componentInstance.register();
			} )
		} )
	}
}
