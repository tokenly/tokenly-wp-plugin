import * as React from 'react'
import AddressCard from './AddressCard'
import ResourceList from '../../Components/ResourceList'
import AddressCollectionInterface
	from '../../../Interfaces/Collections/Token/AddressCollectionInterface'

interface AddressListProps {
	addresses: AddressCollectionInterface
}

export default function AddressList( props: AddressListProps ) {
	return (
		<ResourceList
			items={ props.addresses }
			component={ AddressCard }
			itemProp="address"
			notFoundLabel="addresses"
		/>
	)
}
