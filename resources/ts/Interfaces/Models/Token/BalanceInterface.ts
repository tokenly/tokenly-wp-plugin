import ModelInterface from '../ModelInterface'
import AssetInterface from './AssetInterface';
import MetaInterface from './MetaInterface';
import QuantityInterface from './QuantityInterface';

export default interface BalanceInterface extends ModelInterface {
	name?: string
	precision?: number
	asset?: AssetInterface
	quantity?: QuantityInterface
	meta?: MetaInterface
}