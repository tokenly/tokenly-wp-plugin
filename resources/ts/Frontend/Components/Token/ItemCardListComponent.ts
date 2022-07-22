import ItemCardListComponent from '../ItemCardListComponent'
import ItemCardListComponentInterface from '../../Interfaces/Components/Token/ItemCardListComponentInterface'

import { injectable, inject, interfaces } from 'inversify'
import { TYPES } from '../../Types'
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface'
import ItemCardComponentInterface from '../../Interfaces/Components/Token/ItemCardComponentInterface'
import MasonryGrid from '../MasonryGrid'

@injectable()
export default class TokenItemCardListComponent extends ItemCardListComponent implements ItemCardListComponentInterface {
	protected serviceMethod: string = 'tokenBalanceIndex'
	protected templateDir: string = '/resources/views/js/Token/ItemCardComponent.twig'
	protected masonryGrid: any
	protected fallbackImage: string
	
	public constructor(
		@inject( TYPES.Variables.pluginUrl ) pluginUrl: string,
		@inject( TYPES.Variables.fallbackImage ) fallbackImage: string,
		@inject( TYPES.Repositories.UserRepositoryInterface ) userRepository: UserRepositoryInterface,
		@inject( TYPES.Factories.Token.ItemCardComponentFactoryInterface ) itemCardComponentFactory: interfaces.AutoFactory<ItemCardComponentInterface>
	) {
		super( pluginUrl, userRepository )
		this.fallbackImage = fallbackImage
		this.cardFactory = itemCardComponentFactory
	}

	/**
	 * Creates and registers the objects used to control the cards
	 * @param Array<any> cards 
	 */
	protected initCards( cards: any ): void {
		super.initCards( cards )
		if ( this.masonryGrid ) {
			this.masonryGrid.destroy()
		}
		if ( this.style == 'masonry' ) {
			this.masonryGrid = new MasonryGrid( this.itemContainer, cards, this?.user?.name )
		}
	}

	/**
	 * Formats a balance object to make it suitable for card rendering
	 * @param {object} balance Initial balance
	 * @returns {object} Formatted balance
	 */
	protected formatBalance( balance: any ): object {
		let balanceFormatted: object = super.formatBalance( balance )
		const quantity = balance?.quantity?.value.toLocaleString( 'en-US', {
			maximumFractionDigits: 4,
		} )
		let image = balance.meta?.image ?? this.fallbackImage
		if ( !image ) {
			image = this.fallbackImage
		}
		balanceFormatted = Object.assign( balanceFormatted, {
			image: image,
			name: balance.meta?.name ?? balance.name,
			description: balance.meta?.description ?? null,
			balance: quantity,
			asset: balance.asset,
			extra: balance.meta?.extra,
			style: this.style,
			meta_slug: balance?.meta?.slug,
		} )
		return balanceFormatted
	}
}
