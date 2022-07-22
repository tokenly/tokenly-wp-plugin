import * as React from 'react'

interface GroupLinkProps {
	uuid: string,
}

export default function GroupLink( props: GroupLinkProps ) {
	return(
		<div>
			<span>№ </span>
			<b>
				<span>{ props.uuid }</span>
			</b>
		</div>
	)
}
 

