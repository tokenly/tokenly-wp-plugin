import * as React from 'react';

import { 
	Flex,
	TextControl,
} from '@wordpress/components';

interface QuantityFieldProps {
	quantity: number;
	onChange: any;
	max?: number;
	inputProps?: any;
}

export default function QuantityField( props: QuantityFieldProps ) {
	return (
		<Flex> 
			<label>
				Quantity
				<Flex justify="flex-start" align="center" style={ { paddingTop: '12px' } }>
					<TextControl
						type="number"
						value={ props.quantity }
						min={ 0 }
						style={ { maxWidth: '100px' } }
						onChange={ (value: any) => {
							props.onChange( value );
						} }
						{ ...props?.inputProps }
					/>
					{ props.max &&
						<span>
							<span>of / </span>
							<span title={ props.max as any }>
								<b>{ parseFloat( props.max.toFixed( 4 ) ) }</b>
							</span>
						</span>
					}
				</Flex>
			</label>
		</Flex>
	);
}
 

