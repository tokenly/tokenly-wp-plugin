import * as React from 'react';

import { 
	Flex,
} from '@wordpress/components';

interface ResourceListProps {
	items: Array<any>;
	component: any;
	itemProp: string;
	notFoundLabel?: string;
}

export default function ResourceList( props: ResourceListProps ) {
	let listItems = [] as any;
	if ( props.items && Array.isArray( props.items ) ) {
		listItems = props?.items.map( ( item: any, i: number ) => {
			const cardProps = {
				[props.itemProp]: item,
			}
			return (
				<props.component {...cardProps} />
			);
		} );
	}
	return (
		<div style={ { width: '100%' } }>
			{ ( Array.isArray( props.items ) && props.items.length > 0 )
			?	<Flex
					style={ { width: '100%' } }
					// @ts-ignore
					direction="column"
				>
					{ listItems }
				</Flex>
			: 	<div style={ { opacity: 0.5 } }>{ `No ${props.notFoundLabel ?? 'items'} were found.` }</div>
			}
		</div>
	);
}
