import ModelInterface from '../ModelInterface';

import MetaInterface from '../../Models/Token/MetaInterface';
import PromiseMetaInterface from '../../Models/Token/PromiseMetaInterface';
import SourceInterface from '../../Models/Token/SourceInterface';
import QuantityInterface from '../../Models/Token/QuantityInterface';
import AssetInterface from '../../Models/Token/AssetInterface';

export default interface PromiseInterface extends ModelInterface {
	sourceId?: string;
	destination?: string;
	fingerprint?: string;
	txid?: string;
	createdAt?: string;
	updatedAt?: string;
	expiration?: string;
	ref?: string;
	pseudo?: boolean;
	note?: string;
	protocol?: string;
	chain?: string;
	promiseId?: number;
	asset?: AssetInterface;
	source?: SourceInterface;
	quantity?: QuantityInterface;
	promiseMeta?: PromiseMetaInterface;
	tokenMeta?: MetaInterface;
}