import * as React from 'react';
import AddressCard from './AddressCard';
import ResourceList from '../../Components/ResourceList';

interface AddressListProps {
	addresses: Array<any>;
}

export default function AddressList( props: AddressListProps ) {
	return (
		<ResourceList
			items={ props.addresses }
			component={ AddressCard }
			itemProp="address"
			notFoundLabel="addresses"
		/>
	);
}
