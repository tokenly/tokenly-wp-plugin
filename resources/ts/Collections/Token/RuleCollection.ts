import Collection from '../Collection';
import RuleCollectionInterface from
	'../../Interfaces/Collections/Token/RuleCollectionInterface';
import Rule from '../../Models/Token/Rule';

export default class RuleCollection extends Collection
	implements RuleCollectionInterface
{
	protected class = Rule;
}
