import * as React from 'react';

interface AutocompleteProps {
	onChange: any;
	options: any;
}

export default function Autocomplete( props: AutocompleteProps ) {
	const optionElements = props.options.map( ( option: any ) => {
		return (
			<div 
				onMouseDown={ () => {
					props.onChange( option.value );
				} }
				className="autocomplete-item"
			>
				{ option.label }
			</div>
		);
	} );

	return (
		<div className="tokenly-autocomplete">{ optionElements }</div>
	);
}
