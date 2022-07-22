import { injectable, inject } from 'inversify'
import { TYPES } from '../../Types'
import Component from './Component'
import UserRepositoryInterface
	from '../../Interfaces/Repositories/UserRepositoryInterface'
import BalanceComponentInterface
	from '../Interfaces/Components/BalanceComponentInterface'


@injectable()
export default class BalanceComponent extends Component
	implements BalanceComponentInterface
{
	protected userRepository: any
	protected _balance: number
	protected serviceMethod: string
	protected identifier: string
	protected valueElement: HTMLElement
	protected loaderElement: HTMLElement

	constructor(
		@inject(
			TYPES.Repositories.UserRepositoryInterface
		) userRepository: UserRepositoryInterface,
	) {
		super()
		this.userRepository = userRepository
	}
	
	register( selector: string ) {
		this.valueElement = this.element.querySelector( '.value' )
		this.loaderElement = this.element.querySelector( '.tokenly-loader' )
		const user = this.element.dataset.user
		const identifier = this.element.dataset[ this.identifier ]
		this.userRepository[ this.serviceMethod ](
			user, identifier
		).then( ( balance: any ) => {
			this.balance = this.formatBalance( balance )
			this.loaderElement.style.display = 'none'
		} )
	}

	protected formatBalance( balance: any ) {
		return 0
	}

	protected get balance() {
		return this._balance
	}

	protected set balance( value: any ) {
		this._balance = value
		this.valueElement.textContent = value
	}
}
