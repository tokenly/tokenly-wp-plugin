import TermCollection from '../TermCollection'
import CategoryTermCollectionInterface from '../../Interfaces/Collections/Token/CategoryTermCollectionInterface'
import CategoryTerm from '../../Models/Token/CategoryTerm'

export default class CategoryTermCollection extends TermCollection implements CategoryTermCollectionInterface {
	protected class = CategoryTerm
}
