import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface AddressSelectProps {
	address: any;
	addresses: any;
	loading: boolean;
	onChange: any;
}

interface AddressSelectState {
	//
}

export default class AddressSelect extends Component<AddressSelectProps, AddressSelectState> {

	constructor( props: AddressSelectProps ) {
		super( props );
	}

	getAddressOptions() {
		const options = [
			{
				label: '-- select an address --',
				value: '',
			}
		];
		if ( this.props.addresses && typeof this.props.addresses === 'object' ) {
			Object.keys( this.props.addresses ).forEach( ( key ) => {
				options.push( {
					label: this.props.addresses[ key ].label,
					value: key,
				} );
			});
		}
		console.log(options);
		return options;
	}

	render() {
		const addressOptions = this.getAddressOptions();
		return (
			<Flex> 
				<label>Address
					<Flex
						//@ts-ignore
						direction="column"
					>
						<div style={ { opacity: 0.8 } }>Blockchain wallet address.</div>
						<Flex
							style={ { maxWidth: "320px" } }
							justify="flex-start"
							gap={4}
						>
							<SelectControl
								label=""
								disabled={this.props.loading || addressOptions.length === 1}
								value={ this.props.address }
								style={ { width: '100%' } }
								options={ addressOptions }
								required
								onChange={ ( value: any ) => {
									this.props.onChange( value );
								} }
							/>
							{ this.props.loading &&
								<Spinner />
							}
						</Flex>
					</Flex>
				</label>
			</Flex>
		);
	}
}
 

