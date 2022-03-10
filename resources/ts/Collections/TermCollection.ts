import Collection from './Collection';
import TermCollectionInterface from '../Interfaces/Collections/TermCollectionInterface';
import ProtectableInterface from '../Interfaces/Mixins/ProtectableInterface';
import Term from '../Models/Term';

export default class TermCollection extends Collection implements TermCollectionInterface, ProtectableInterface {
	protected class = Term;
}
