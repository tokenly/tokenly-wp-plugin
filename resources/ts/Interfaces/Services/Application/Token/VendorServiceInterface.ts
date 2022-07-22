import { TokenVendorPromiseParamsInterface } from '../../../Services/ApiServiceInterface'

export default interface VendorServiceInterface {
	promise( params?: TokenVendorPromiseParamsInterface ): Promise<any>
}
