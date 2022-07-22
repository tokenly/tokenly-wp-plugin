import { injectable, inject } from 'inversify'
import Component from './Component'
import { TYPES } from '../Types'
import UserRepositoryInterface
	from '../../Interfaces/Repositories/UserRepositoryInterface'
import ItemCardListComponentInterface
	from '../Interfaces/Components/Token/ItemCardListComponentInterface'
import BalanceCollectionInterface
	from '../../Interfaces/Collections/Token/BalanceCollectionInterface'
import BalanceInterface from '../../Interfaces/Models/Token/BalanceInterface'
import CollectionInterface from '../../Interfaces/Collections/CollectionInterface'

const Twig = require( '/node_modules/twig/twig.min.js' )

@injectable()
export default class ItemCardListComponent extends Component
	implements ItemCardListComponentInterface
{
	public element: HTMLElement
	protected pluginUrl: string
	protected userRepository: any
	protected cardFactory: any
	protected _balances: CollectionInterface
	protected cardTemplate: any
	protected itemContainer: any
	protected serviceMethod: string = ''
	protected templateDir: string = ''
	protected gridSizer: HTMLElement
	protected grid: any
	protected _style: string = 'grid'
	protected styleSwitches: any
	protected filter: string
	protected user: any
	
	public constructor(
		@inject( TYPES.Variables.pluginUrl ) pluginUrl: string,
		@inject(
			TYPES.Repositories.UserRepositoryInterface
		) userRepository: UserRepositoryInterface,
	) {
		super()
		this.pluginUrl = pluginUrl
		this.userRepository = userRepository
	}

	public register(): void {
		this.itemContainer = this.element.querySelector( '.items' )
		this.gridSizer = this.element.querySelector( '.grid-sizer' )
		this.initStyleSwitches()
		this.initSearchField()
		this.loadBalances()
	}

	protected initStyleSwitches(): void {
		this._style = this.element.dataset.style
		this.styleSwitches = this.element.querySelectorAll(
			'.action-container .style-select'
		)
		if ( !this.styleSwitches ) {
			return
		}
		this.styleSwitches.forEach( ( switchElement: any ) => {
			const style = switchElement.dataset.style
			if ( style === this.style ) {
				switchElement.classList.add( 'active' )
			} 
			switchElement.addEventListener('click', () => {
				this.style = style
				this.resetStyleSwitchStates()
				switchElement.classList.add( 'active' )
			} )
		} )
	}

	protected initSearchField(): void {
		const input = this.element.querySelector( `input[type='search']` )
		if ( !input ) {
			return
		}
		input.addEventListener( 'change', ( event: any ) => {
			this.filter = event.target.value
			this.refreshCards()
		} )
	}

	public get balances(): CollectionInterface {
		return this._balances
	}

	public set balances( balances: CollectionInterface ) {
		this._balances = balances
		this.refreshCards()
	}

	/**
	 * Loads a collection of balance
	 * @returns {Promise<any>}
	 */
	protected loadBalances(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			const userId = this.element.dataset.user
			this.userRepository.show( userId ).then( ( user: any ) => {
				this.user = user
			} ).then( () => {
				this.userRepository[ this.serviceMethod ]( userId ).then( (
					balances: CollectionInterface
				) => {
					this.balances = balances
					resolve( true )
				} )
			} )

		} )
	}

	/**
	 * Loads the Twig template for cards from the server
	 * @returns {Promise<any>}
	 */
	protected loadCardMacroTemplate(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			if ( this.cardTemplate ) {
				resolve( this.cardTemplate )
			} else {
				Twig.twig( {
					href: `${this.pluginUrl}${this.templateDir}`,
					load: ( template: any ) => {
						this.cardTemplate = template
						resolve( template )
					},
				} )
			}
		} )
	}
	
	/**
	 * Renders the cards using the Twig template provided
	 * @param template Template to use when rendering
	 * @param {Array<object>} balances Balances to use as data for the cards
	 * @returns {Promise<string>} Rendered HTML
	 */
	protected renderCards(): Promise<string> {
		return new Promise( ( resolve, reject ) => {
			if (!this.balances) {
				return
			}
			let balances: BalanceCollectionInterface = this.balances.clone()
			balances = this.filterBalances( balances )
			this.loadCardMacroTemplate().then( ( template: any ) => {
				const balancesArray = Array.from( balances.values() ).map( (
					balance: any
				) => {
					balance = this.formatBalance( balance )
					const html = template.render( balance )
					return html
				} )
				if ( balancesArray.length == 0 ) {
					this.element.classList.add( 'is-empty' )
				} else {
					this.element.classList.remove( 'is-empty' )
				}
				const html = balancesArray.join( '' )
				resolve( html )
			} )
		} )
	}

	protected filterBalances( balances: BalanceCollectionInterface ) {
		if ( this.filter && this.filter != '' ) {
			balances.forEach( ( balance: BalanceInterface, key: any ) => {
				if ( balance.name != this.filter ) {
					balances.delete( key )
				}
			} )
			const sequential = balances.toSequential()
			return sequential
		}
		return balances
	}

	/**
	 * Formats a balance object to make it suitable for card rendering
	 * @param {object} balance Initial balance
	 * @returns {object} Formatted balance
	 */
	protected formatBalance( balance: any ): object {
		return {
			style: this.style,
		}
	}

	protected initAllCards():void {
		this.initCards( this.itemContainer.children )
	}

	/**
	 * Creates and registers the objects used to control the cards
	 * @param Array<any> cards 
	 */
	protected initCards( cards: any ): void {
		Array.from( cards ).forEach( ( cardElement: any ) => {
			if ( cardElement ) {
				if ( !cardElement.cardManager ) {
					const cardManager = this.cardFactory()
					cardElement.cardManager = cardManager
					cardManager.element = cardElement
					cardManager.register()
				}
			}
		} )
	}

	protected get style(): string {
		return this._style
	}

	protected set style( value: string ) {
		this._style = value
		this.element.dataset.style = value
		this.refreshCards()
	}

	protected resetStyleSwitchStates(): void {
		this.styleSwitches.forEach( ( switchElement: any ) => {
			switchElement.classList.remove( 'active' )
		} )
	}

	/**
	 * Re-renders and replaces all cards
	 * @returns {Promise<any>}
	 */
	protected refreshCards(): Promise<any> {
		return new Promise( ( resolve, reject ) => {
			this.renderCards().then( ( cardsHtml: any ) => {
				this.itemContainer.innerHTML = cardsHtml
				this.initAllCards()
				this.element.classList.remove( 'loading' )
				resolve( true )
			} ) 
		} )
	}
}
