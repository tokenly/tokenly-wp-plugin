import * as React from 'react';

import { 
	SelectControl,
} from '@wordpress/components';

interface TransactionTypeFieldProps {
	type: string;
	onChange: any;
	inputProps?: any;
	label?: string;
}

export default function TransactionTypeField( props: TransactionTypeFieldProps ) {
	return (
		<SelectControl
			label={ props?.label ?? 'Transaction Type' }
			value={ props.type }
			options={ [
				{ label: 'Debit' , value: 'debit' },
				{ label: 'Credit'  , value: 'credit'  },
			] }
			onChange={ props.onChange }
			{ ...props?.inputProps }
		/>
	);
}
 

