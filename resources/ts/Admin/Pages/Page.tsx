import * as React from 'react';
import BackButton from '../Components/BackButton';

import { 
	Fragment,
} from '@wordpress/element';

interface PageProps {
	title: string,
	children: any;
}

export default function Page( props: PageProps ) {
	return (
		<Fragment>
			<h2>{ props.title }</h2>
			<BackButton />
			<div style={ { marginTop: '8px' } } >
				{ props.children }
			</div>
		</Fragment>
	)
}
