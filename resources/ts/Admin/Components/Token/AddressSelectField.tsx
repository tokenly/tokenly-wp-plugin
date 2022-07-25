import * as React from 'react'

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components'
import AddressCollectionInterface
	from '../../../Interfaces/Collections/Token/AddressCollectionInterface'
import AddressInterface
	from '../../../Interfaces/Models/Token/AddressInterface'

interface AddressSelectFieldProps {
	address: string
	addresses: AddressCollectionInterface
	loading: boolean
	onChange: ( address: string ) => void
	label?: string
	inputProps?: any
}

export default function AddressSelectField( props: AddressSelectFieldProps ) {
	function getAddressOptions() {
		const options = [
			{
				label: 'Not Selected',
				value: '',
			}
		]
		props.addresses.forEach( ( address: AddressInterface, key: any ) => {
			options.push( {
				label: address.label,
				value: key,
			} )
		} )
		if ( props.addresses && typeof props.addresses === 'object' ) {
			Object.keys( props.addresses ).forEach( ( key ) => {
				options.push(  )
			} )
		}
		return options
	}

	const addressOptions = getAddressOptions()
	return (
		<Flex
			//@ts-ignore
			direction="column"
		>
			<Flex
				style={ { maxWidth: "320px" } }
				justify="flex-start"
				align="center"
				gap={ 4 }
			>
				<SelectControl
					label={ props?.label ?? 'Address' }
					disabled={ props.loading || addressOptions.length === 1 }
					value={ props.address }
					style={ { width: '100%' } }
					options={ addressOptions }
					onChange={ props.onChange }
					{ ...props?.inputProps }
				/>
				{ props.loading &&
					<Spinner />
				}
			</Flex>
		</Flex>
	)
}
 

