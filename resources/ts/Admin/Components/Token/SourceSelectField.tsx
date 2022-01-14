import * as React from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface SourceSelectFieldProps {
	source: any;
	sources: any;
	loading: boolean;
	onChange: any;
}

export default function SourceSelectField( props: SourceSelectFieldProps ) {
	function getSourceOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		];
		if ( props.sources && typeof props.sources === 'object' ) {
			Object.keys( props.sources ).forEach( ( key ) => {
				options.push( {
					label: props.sources[ key ]?.address.label ?? key,
					value: key,
				} );
			} );
		}
		return options;
	}

	const sourceOptions = getSourceOptions();
	return (
		<Flex> 
			<label>
				<div style={ { marginBottom: '8px' } } >Source</div>
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
							disabled={ props.loading || sourceOptions.length === 1 }
							value={ props.source }
							style={ { width: '100%' } }
							options={ sourceOptions }
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
 

