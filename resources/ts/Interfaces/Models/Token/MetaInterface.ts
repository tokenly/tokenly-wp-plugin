import PostInterface from '../PostInterface'

export default interface MetaInterface extends PostInterface {
	assetName?: string
	attributes?: object
	media?: object
	blockchain?: string
	protocol?: string
	slug?: string
	asset?: object
}