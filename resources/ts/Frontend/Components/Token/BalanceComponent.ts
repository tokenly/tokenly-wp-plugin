import BalanceComponentInterface from '../../Interfaces/Components/Token/BalanceComponentInterface'
import BalanceComponent from '../BalanceComponent'

import { injectable } from 'inversify'

@injectable()
export default class TokenBalanceComponent extends BalanceComponent implements BalanceComponentInterface {
	protected serviceMethod: string = 'tokenBalanceShow'
	protected identifier: string = 'asset'

	protected formatBalance( balance: any ) {
		return balance?.quantity?.value
	}
}
