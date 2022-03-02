import {
	CreditVendorDebitParamsInterface,
	CreditVendorCreditParamsInterface,
} from '../../../Services/ApiServiceInterface';

export default interface VendorServiceInterface {
	credit( params?: CreditVendorCreditParamsInterface ): Promise<any>;
	debit( params?: CreditVendorDebitParamsInterface ): Promise<any>;
}
