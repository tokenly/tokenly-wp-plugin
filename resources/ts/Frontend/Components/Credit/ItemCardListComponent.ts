import { injectable, inject, interfaces } from 'inversify'
import { TYPES } from '../../Types'
import ItemCardListComponent from '../ItemCardListComponent'
import UserRepositoryInterface
	from '../../../Interfaces/Repositories/UserRepositoryInterface'
import GroupRepositoryInterface
	from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface'
import ItemCardListComponentInterface
	from '../../Interfaces/Components/Credit/ItemCardListComponentInterface'
import ItemCardComponentInterface
	from '../../Interfaces/Components/Credit/ItemCardComponentInterface'
import AccountInterface from '../../../Interfaces/Models/Credit/AccountInterface'
import GroupCollectionInterface from '../../../Interfaces/Collections/Credit/GroupCollectionInterface'

@injectable()
export default class CreditItemCardListComponent extends ItemCardListComponent
	implements ItemCardListComponentInterface
{	
	protected serviceMethod: string = 'creditBalanceIndex'
	protected templateDir: string = '/resources/views/js/Credit/ItemCardComponent.twig'
	protected groupRepository: GroupRepositoryInterface
	protected groups: GroupCollectionInterface

	constructor(
		@inject( TYPES.Variables.pluginUrl ) pluginUrl: string,
		@inject(
			TYPES.Repositories.UserRepositoryInterface
		) userRepository: UserRepositoryInterface,
		@inject(
			TYPES.Repositories.Credit.GroupRepositoryInterface
		) groupRepository: GroupRepositoryInterface,
		@inject(
			TYPES.Factories.Credit.ItemCardComponentFactoryInterface
		) itemCardComponentFactory: 
			interfaces.AutoFactory<ItemCardComponentInterface>,
	) {
		super( pluginUrl, userRepository )
		this.groupRepository = groupRepository
		this.groupRepository.index().then( (result) => {
			this.groups = result.keyByField( 'uuid' )
			this.refreshCards()
		} )
		this.cardFactory = itemCardComponentFactory
	}
	
	/**
	 * Formats a balance object to make it suitable for card rendering
	 * @param {object} balance Initial balance
	 * @returns {object} Formatted balance
	 */
	formatBalance( balance: any ): object {
		const account = balance as AccountInterface
		let accountFormatted: object = super.formatBalance( account )
		const quantity = balance?.balance.toLocaleString( 'en-US', {
			maximumFractionDigits: 4,
		} )
		accountFormatted = Object.assign( accountFormatted, {
			name: this.groups.get( account.groupId ).name,
			balance: quantity,
		} )
		return accountFormatted
	}
}
