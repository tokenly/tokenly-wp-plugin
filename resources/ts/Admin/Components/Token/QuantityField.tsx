import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	TextControl,
} from '@wordpress/components';

interface QuantityFieldProps {
	quantity: number;
	onChange: any;
	max?: number;
}

interface QuantityFieldState {
	//
}

export default class QuantityField extends Component<QuantityFieldProps, QuantityFieldState> {

	constructor( props: QuantityFieldProps ) {
		super( props );
	}

	render() {
		return (
			<Flex> 
				<label>
					Quantity
					<Flex justify="flex-start" align="center" style={ { paddingTop: '12px' } }>
						<TextControl
							type="number"
							value={ this.props.quantity }
							min={ 0 }
							style={ { maxWidth: '100px' } }
							onChange={ (value: any) => {
								this.props.onChange( value );
							} }
						/>
						{ this.props.max &&
							<span>
								<span>of / </span>
								<span title={ this.props.max as any }>
									<strong>{ parseFloat( this.props.max.toFixed( 4 ) ) }</strong>
								</span>
							</span>
						}
					</Flex>
				</label>
			</Flex>
		);
	}
}
 

