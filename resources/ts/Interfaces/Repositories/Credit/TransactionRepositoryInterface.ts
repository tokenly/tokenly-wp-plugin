import TransactionCollectionInterface from "../../Collections/Credit/TransactionCollectionInterface";
import TransactionInterface from "../../Models/Credit/TransactionInterface";

export default interface TransactionRepositoryInterface {
	index( params: any ): Promise<TransactionCollectionInterface>;
	store( params: any ): Promise<TransactionInterface>;
}
