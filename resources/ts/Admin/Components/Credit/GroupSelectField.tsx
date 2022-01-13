import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
	Spinner,
	SelectControl,
} from '@wordpress/components';

interface GroupSelectFieldProps {
	group: any;
	groups: any;
	loading: boolean;
	onChange: any;
}

export default function GroupSelectField( props: GroupSelectFieldProps ) {
	function getGroupOptions() {
		const options = [
			{
				label: 'Not selected',
				value: '',
			}
		];
		if ( props.groups && Array.isArray( props.groups ) ) {
			props.groups.forEach( ( group: any ) => {
				options.push( {
					label: group.name,
					value: group.uuid,
				} );
			});
		}
		return options;
	}

	const groupOptions = getGroupOptions();
	return (
		<Flex> 
			<label>
				<div style={ { marginBottom: '8px' } } >Group</div>
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
							disabled={props.loading || groupOptions.length === 1}
							value={ props.group }
							style={ { width: '100%' } }
							options={ groupOptions }
							required
							onChange={ ( value: any ) => {
								props.onChange( value );
							} }
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
 

