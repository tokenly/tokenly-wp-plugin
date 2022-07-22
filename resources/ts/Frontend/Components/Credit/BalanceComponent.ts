import BalanceComponentInterface from '../../Interfaces/Components/Credit/BalanceComponentInterface'
import BalanceComponent from '../BalanceComponent'

import { injectable } from 'inversify'

@injectable()
export default class CreditBalanceComponent extends BalanceComponent implements BalanceComponentInterface {
	protected serviceMethod: string = 'creditBalanceShow'
	protected identifier: string = 'group'

	protected formatBalance( balance: any ) {
		return balance?.balance
	}
}
