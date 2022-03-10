import Collection from '../Collection';
import PromiseCollectionInterface from '../../Interfaces/Collections/Token/PromiseCollectionInterface';
import TokenPromise from '../../Models/Token/Promise';

export default class PromiseCollection extends Collection implements PromiseCollectionInterface {
	protected class = TokenPromise;
}
