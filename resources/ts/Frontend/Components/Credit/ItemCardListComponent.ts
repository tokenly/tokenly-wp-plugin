import { injectable, inject, interfaces } from 'inversify'
import { TYPES } from '../../Types'
import ItemCardListComponent from '../ItemCardListComponent'
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface'
import ItemCardListComponentInterface from '../../Interfaces/Components/Credit/ItemCardListComponentInterface'
import ItemCardComponentInterface from '../../Interfaces/Components/Credit/ItemCardComponentInterface'

@injectable()
export default class CreditItemCardListComponent extends ItemCardListComponent implements ItemCardListComponentInterface {
	protected serviceMethod: string = 'creditBalanceIndex'
	protected templateDir: string = '/resources/views/js/Credit/ItemCardComponent.twig'
	
	constructor(
		@inject( TYPES.Variables.pluginUrl ) pluginUrl: string,
		@inject( TYPES.Repositories.UserRepositoryInterface ) userRepository: UserRepositoryInterface,
		@inject( TYPES.Factories.Credit.ItemCardComponentFactoryInterface ) itemCardComponentFactory: interfaces.AutoFactory<ItemCardComponentInterface>,
	) {
		super( pluginUrl, userRepository )
		this.cardFactory = itemCardComponentFactory
	}
	
	/**
	 * Formats a balance object to make it suitable for card rendering
	 * @param {object} balance Initial balance
	 * @returns {object} Formatted balance
	 */
	formatBalance( balance: any ): object {
		let balanceFormatted: object = super.formatBalance( balance )
		const quantity = balance?.balance.toLocaleString( 'en-US', {
			maximumFractionDigits: 4,
		} )
		balanceFormatted = Object.assign( balanceFormatted, {
			name: balance.group?.name,
			balance: quantity,
		} )
		return balanceFormatted
	}
}
