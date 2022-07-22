import * as React from 'react'

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components'

interface AddressSelectFieldProps {
	address: any
	addresses: any
	loading: boolean
	onChange: any
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
		if ( props.addresses && typeof props.addresses === 'object' ) {
			Object.keys( props.addresses ).forEach( ( key ) => {
				options.push( {
					label: props.addresses[ key ].label,
					value: key,
				} )
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
 

