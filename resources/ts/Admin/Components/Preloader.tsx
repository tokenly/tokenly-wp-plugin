import * as React from 'react';

import { 
	Flex,
	Spinner,
} from '@wordpress/components';

interface PreloaderProps {
	loading: boolean;
	href?: string;
	children?: any;
}

export default function Preloader( props: PreloaderProps ) {
	return (
		<Flex justify="flex-start" align="center" style={ { fontWeight: 700, minHeight: '30px' } }>
			<span>{ props.children }</span>
		{ props.loading &&
			<Spinner />
		}
		</Flex>
	);
}
