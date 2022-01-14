import * as React from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface AddressSelectFieldProps {
	address: any;
	addresses: any;
	loading: boolean;
	onChange: any;
}

export default function AddressSelectField( props: AddressSelectFieldProps ) {
	function getAddressOptions() {
		const options = [
			{
				label: 'Not Selected',
				value: '',
			}
		];
		if ( props.addresses && typeof props.addresses === 'object' ) {
			Object.keys( props.addresses ).forEach( ( key ) => {
				options.push( {
					label: props.addresses[ key ].label,
					value: key,
				} );
			} );
		}
		return options;
	}

	const addressOptions = getAddressOptions();
	return (
		<Flex> 
			<label>
				<div style={ { marginBottom: '8px' } } >Address</div>
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
							label=""
							disabled={ props.loading || addressOptions.length === 1 }
							value={ props.address }
							style={ { width: '100%' } }
							options={ addressOptions }
							required
							onChange={ props.onChange }
						/>
						{ props.loading &&
							<Spinner />
						}
					</Flex>
				</Flex>
			</label>
		</Flex>
	);
}
 

