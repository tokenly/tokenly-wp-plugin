import * as React from 'react';
import { Component } from 'react';

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

interface AddressSelectFieldState {
	//
}

export default class AddressSelectField extends Component<AddressSelectFieldProps, AddressSelectFieldState> {

	constructor( props: AddressSelectFieldProps ) {
		super( props );
	}

	getAddressOptions() {
		const options = [
			{
				label: 'Not selected',
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
		return options;
	}

	render() {
		const addressOptions = this.getAddressOptions();
		return (
			<Flex> 
				<label>
					<div style={{marginBottom: '8px'}} >Address</div>
					<Flex
						//@ts-ignore
						direction="column"
					>
						<Flex
							style={ { maxWidth: "320px" } }
							justify="flex-start"
							align="center"
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
 

